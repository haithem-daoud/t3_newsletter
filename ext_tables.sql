#
# Table structure for table 'tx_t3newsletter_domain_model_subscription'
#
CREATE TABLE tx_t3newsletter_domain_model_subscription (
       firstname varchar(150) DEFAULT '' NOT NULL,
       lastname varchar(150) DEFAULT '' NOT NULL,
        email varchar(255) DEFAULT '' NOT NULL,
        gender varchar(100) DEFAULT '' NOT NULL,
        company varchar(200) DEFAULT '' NOT NULL,
        data_privacy_accepted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        token varchar(32) DEFAULT '' NOT NULL
);