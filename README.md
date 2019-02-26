## FLYERALARM - Reseller API PHP Binding

The purpose of this repository is to offer a PHP Binding for the FLYERALARM Reseller API.

Please take a look at our examples repository to see how it should be used.

For further details and questions, please contact esolutions@flyeralarm.com
### Setup

- composer needs to be installed https://getcomposer.org
- run composer update
- run "make all" to verify

Notes: PHPUnit Version ranges currently from 5-8 to Support PHP 5.6 and all above versions

### Error Codes

 * 5000 Unknown genereal Error
 * 5010 The FLYERALARM API methods have not been called in the correct order.
 * 5011 The FLYERALARM API method 'login' has to be called first.
 * 5020 The FLYERALARM API business objects only allow specific business objects.
 * 5021 The FLYERALARM API business object lists allow you to use the array access for reading but not for writing. Use the add method of the list.
 * 5022 The data array used to create a ProductGroup object was not valid.
 * 5023 The data array used to create a ProductGroupList object was not valid.
 * 5024 The data array used to create an AttributeValue object was not valid.
 * 5025 The data array used to create an AttributePossibleValues object was not valid.
 * 5026 The data array used to create an Attribute object was not valid..
 * 5027 The data array used to create a ProductQuantityOption object was not valid.
 * 5028 The data array used to create a ProductQuantityOptionList object was not valid.
 * 5029 The data array used to create a ProductOptionList object was not valid.
 * 5030 The data array used to create a ProductShippingTypeList object was not valid.
 * 5031 The data array used to create a ProductShippingOptionList object was not valid.
 * 5032 The data array used to create a ProductPaymentOptionList object was not valid.
 * 5033 The data in your persistency string is corrupted. The order can not be recreated.
 * 5080 This list object only accepts a specific type.
 * 5081 GroupList only accepts objects of type Group.
 * 5082 AttributeList only accepts objects of type Attribute.
 * 5083 AttributePossibleValuesList only accepts objects of type AttributeValue.
 * 5084 OptionList only accepts objects of type Option.
 * 5085 OptionPossibleValuesList only accepts objects of type OptionValue.
 * 5086 PaymentOptionList only accepts objects of type PaymentOption.
 * 5087 QuantityOptionList only accepts objects of type QuantityOption.
 * 5088 ShippingOptionList only accepts objects of type ShippingOption.
 * 5089 ShippingUpgradeList only accepts objects of type ShippingUpgrade.
 * 5090 ShippingTypeList only accepts objects of type ShippingType.
 * 5100 The FLYERALARM API had problems executing your command. Some error happened during th API call.
 * 5101 The FLYERALARM API was not able to login.
 * 5110 Some SOAP call to the FLYERALARM API failed.
 * 5111 FLYERALARM API Call: Unable to load Productgroups.
 * 5112 FLYERALARM API Call: Unable to load ProductAttributes.
 * 5113 FLYERALARM API Call: Unable to load available Attributes by preselected Attributes.
 * 5114 FLYERALARM API Call: Unable to load available Quantities by Attributes.
 * 5115 FLYERALARM API Call: Unable to find Product by QuantityId.
 * 5116 FLYERALARM API Call: Unable to get ShippingTypes.
 * 5117 FLYERALARM API Call: Unable to get available ProductOptions.
 * 5118 FLYERALARM API Call: Unable to get available ShippingOptions.
 * 5119 FLYERALARM API Call: Unable to get available PaymentOptions.
 * 5120 FLYERALARM API Call: Unable to send order.
 * 5150 Some REST call to the FLYERALARM API failed.
 * 5151 FLYERALARM API Call: Unable to reserve an UploadTarget URL.
 * 5152 FLYERALARM API Call: Unable to upload printing data.