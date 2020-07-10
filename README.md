# README #

Example module to add custom fee effect on work flow checkout


### Feature list ###

+ Add config page in BO
+ Load config value in detail product page   
* Add custom fee to checkout cart, checkout index page
+ Save custom fee to order, invoice, creditmemo
+ Add custom fee to download pdf, send email order
+ Filter custom fee in admin grid order, invoice
                   
### How can I set up? ###

Run the following command lines below
```sh
$ composer require trungkienpvt/donate_service
$ bin/magento setup:upgrade
$ bin/magento cache:clean
```
### Reference link ###
* stackoverflow

* [Module custom delivery](https://github.com/sohelrana09/magento2-module-delivery-date)

* [Module custom fee](https://github.com/sivajik34/Custom-Fee-Magento2/tree/master/Sivajik34/CustomFee)

* [webkul](https://webkul.com/blog/add-custom-pricefee-order-total-magento2/)

* [Filter admin order grid](https://github.com/mageworx/articles-extended-orders-grid)