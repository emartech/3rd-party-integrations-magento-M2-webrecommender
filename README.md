# ** Manual Install **

- Locate to the /app/code directory which should be under the magento root installation.
- Download the latest files from master branch and extract the contents
- Copy all files from the downloaded codebase to the "MAGENTO_ROOT/app/code/Emartech/EmarsysRecommender/" directory on you Magento instance
- Make sure you have the correct file and folder permissions set on your magento installation so that the magento store can install the app.
- Refer to the Magento 2 documentation for full instructions on how to install an app, the commands should be similar to the following:
  - php bin/magento module:enable Emartech_EmarsysRecommender 
  - php bin/magento setup:upgrade
  - php bin/magento setup:di:compile
  - php bin/magento setup:static-content:deploy 
  - php bin/magento cache:flush
  
  
# ** Composer Setup **
- composer config repositories.emartech-3rd-party-integrations-magento-M2-webrecommender git git@github.com:emartech/3rd-party-integrations-magento-M2-webrecommender
- composer require ematech/3rd-party-integrations-magento-M2-webrecommender
- php bin/magento module:enable Emartech_EmarsysRecommender
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush
