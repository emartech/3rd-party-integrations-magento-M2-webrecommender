# ** Manual Install **

- Locate to the /app/code directory which should be under the magento root installation.
- Download the latest files from master branch and extract the contents
- Copy all files from the downloaded codebase to the "MAGENTO_ROOT/app/code/" directory on you Magento instance (you have to get something like MAGENTO_ROOT/app/code/Emartech/EmarsysRecommender/... in the end)

# ** Magento Setup **

- Make sure you have the correct file and folder permissions set on your magento installation so that the magnento store can install the app.
- Refer to the Magento 2 documentation for full instructions on how to install an app, the commands should be similar to the following: 
  - php bin/magento setup:upgrade
  - php bin/magento setup:di:compile
  - php bin/magento setup:static-content:deploy 
  - php bin/magento cache:flush
