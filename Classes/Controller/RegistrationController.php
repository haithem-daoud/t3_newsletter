<?php
namespace TYPO3\T3Newsletter\Controller;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\T3Newsletter\Domain\Model\Subscription;
use TYPO3\T3Newsletter\Domain\Repository\SubscriptionRepository;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * RegistrationController
 */
class RegistrationController extends ActionController {

    private StandaloneView $standaloneView;

    /**
     * subscriptionRepository
     *
     * @var SubscriptionRepository
     */
    protected SubscriptionRepository $subscriptionRepository;

    /**
     * @var PersistenceManager
     */
    protected PersistenceManager $persistenceManager;

    public function __construct(
        StandaloneView $standaloneView,
        SubscriptionRepository $subscriptionRepository,
        PersistenceManager $persistenceManager
    ) {
        $this->standaloneView = $standaloneView;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * @param Subscription|null $subscription
     * @throws IllegalObjectTypeException
     */
    public function indexAction(?Subscription $subscription = null): ResponseInterface
    {
        $token = GeneralUtility::_GP('t3');
        if ($token)
            return (new ForwardResponse('confirm'))
                ->withControllerName('Registration')
                ->withExtensionName('T3Newsletter')
                ->withArguments(['token' => $token]);

        if ($subscription) {
            $errors = $this->validateSubscription($subscription);

            if (!$errors) {
                try {
                    $token = StringUtility::getUniqueId();
                    $subscription->setToken($token);

                    $confirmationEmailSent = $this->sendConfirmationEmail($subscription);

                    if (!$confirmationEmailSent) {
                        throw new \Exception('Confirmation email could not be sent.');
                    }

                    $subscription->setHidden(true);
                    $this->subscriptionRepository->add($subscription);

                    $this->persistenceManager->persistAll();

                    $this->redirectUser($this->settings['redirectPageUid_Subscribed']);

                } catch (\Exception $ex) {
                    $errors['processError'] = LocalizationUtility::translate('subscription.processError', 't3_newsletter')
                        . '(Exception message: ' . $ex->getMessage() . ')';
                    // Reset Subscription fields
                    $subscription = new Subscription();
                }
            }
        } else {
            $subscription = new Subscription();
        }

        $this->view->assignMultiple([
            'subscription' => $subscription,
            'errors' => $errors ?? []
        ]);

        return $this->htmlResponse();
    }

    /**
     * @param string $token
     * @return void
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     */
    public function confirmAction(string $token): void
    {
        if ($token) $subscription = $this->subscriptionRepository->findSubscriptionByToken($token);

        if ($token && $subscription) {
            if (!$subscription->getEmailConfirmed()) {
                $subscription->setEmailConfirmed(true);
                $subscription->setHidden(false);
                $this->subscriptionRepository->update($subscription);

                $this->persistenceManager->persistAll();

                $message = LocalizationUtility::translate('subscription.confirm.success', 't3_newsletter');
                
            } else {
                $message = LocalizationUtility::translate('subscription.confirm.already-confirmed', 't3_newsletter');
            }
        } else {
            $message = LocalizationUtility::translate('subscription.confirm.error', 't3_newsletter');
        }

        $this->view->assign('message', $message);
    }

    /**
     *
     * @param Subscription $subscription
     * @return array
     * @throws IllegalObjectTypeException
     */
    protected function validateSubscription(Subscription $subscription): array
    {
        if (!$subscription->getGender()) $errors['gender'] = LocalizationUtility::translate('subscription.error.gender', 't3_newsletter');
        if (!$subscription->getFirstname()) $errors['firstname'] = LocalizationUtility::translate('subscription.error.firstname', 't3_newsletter');
        if (!$subscription->getLastname()) $errors['lastname'] = LocalizationUtility::translate('subscription.error.lastname', 't3_newsletter');
        if (!$subscription->getEmailConfirmation()) $errors['email_confirmation']['empty'] = LocalizationUtility::translate('subscription.error.email.confirmation', 't3_newsletter');
        if ($subscription->getEmail() && $subscription->getEmailConfirmation() !== $subscription->getEmail())
            $errors['email_confirmation']['identical'] = LocalizationUtility::translate('subscription.error.email.confirmation.identical', 't3_newsletter');

        if (!filter_var($subscription->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = LocalizationUtility::translate('subscription.error.email', 't3_newsletter');
        } else {
            $existingSubscription = $this->subscriptionRepository->findSubscriptionByEmail($subscription->getEmail());
            if ($existingSubscription) {
                if ($existingSubscription->getEmailConfirmed()) $errors['email'] = LocalizationUtility::translate('subscription.error.email.exists', 't3_newsletter');
                else $this->subscriptionRepository->remove($existingSubscription);
            }
        }
        
        if (!$subscription->getDataPrivacyAccepted()) $errors['data_privacy_accepted'] = LocalizationUtility::translate('subscription.error.data_privacy_accepted', 't3_newsletter');

        return $errors ?? [];
    }
    
    /**
     * 
     * @param Subscription $subscription
     * @return boolean
     */
    protected function sendConfirmationEmail(Subscription $subscription): bool
    {
        $emailView = $this->getEmailView('EmailConfirmation');
    	$emailView->assign('subscription', $subscription);

        // SEND EMAIL
        $email = GeneralUtility::makeInstance(MailMessage::class);
        $email
            ->from(new Address($this->settings['from']))
            ->to(new Address($subscription->getEmail()))
            ->subject($this->settings['confirmationEmailSubject'])
            ->html($emailView->render())
            ->send();
        
        return $email->isSent();
    }

    protected function redirectUser(int $pageUid) {
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->reset();
        $uriBuilder->setTargetPageUid(intval($pageUid));
        $uri = $uriBuilder->build();
        header('Location: ' . $uri);
        exit();
    }
    
    /**
     * 
     * @param string $name
     * @return StandaloneView
     */
    protected function getEmailView(string $name): StandaloneView
    {
        $this->standaloneView->setTemplatePathAndFilename('typo3conf/ext/t3_newsletter/Resources/Private/Templates/Emails/' . $name . '.html');
        $this->standaloneView->setPartialRootPaths([GeneralUtility::getFileAbsFileName('typo3conf/ext/t3_newsletter/Resources/Private/Partials')]);
        return $this->standaloneView;
    }
    
}
