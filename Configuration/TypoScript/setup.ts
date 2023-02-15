plugin.tx_t3newsletter {
    persistence {
        storagePid = 9
        recursive = 0
        classes {
            TYPO3\T3Newsletter\Domain\Model\Subscription.newRecordStoragePid = 73
        }
    }
    features {
        skipDefaultArguments = 1
    }
    settings {
        validation.create {
            firstname {
                1 = "TYPO3.T3Newsletter:Required"
            }
            email {
               1 = "TYPO3.T3Newsletter:UniqueEmail"
            }
        }
    }
}