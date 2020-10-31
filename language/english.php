<?php
/*English Language File*/

class language
{

 
	/*Login Start*/
	var $login='Login';
    var $loginWelcomeMessage='Welcome to Jewelry & Electronic Exchange System. To&nbsp; continue, please login using your username and&nbsp;password below.';
    var $username='Username';
    var $password='Password';
    var $go='Login';
	/*Login End*/
	
		
	/*Menubar Start*/
    var $home='Home';
    var $customers='Customers';
    var $items='Items';
    var $reports='Reports';
    var $sales='Sales';
    var $salesNow='Sale';
    var $config='Config';
    var $poweredBy='Powered by';
    var $welcome='Welcome';
    var $logout='Logout';
	/*Menubar End*/

	
	/*Home Start*/
	var $welcomeTo='Welcome to';
	var $adminHomeWelcomeMessage='Point of Sale system.&nbsp;You are currently logged in<br>as an administrator.<br> With administrative rights, you can go anywhere and do anything on this system.&nbsp';
    var $salesClerkHomeWelcomeMessage='Point of Sale system! To begin,<br>please select the Sales option from the navigation menu.';
    var $reportViewerHomeWelcomeMessage='Point of Sale system! To begin,<br>please select the Reports option from the navigation menu.';
    var $backupDatabase='Backup Database';
    var $processSale='Process A Sale';
    var $addRemoveManageUsers='Add, Remove or Manage Users';
    var $addRemoveManageCustomers='Add, Remove Or Manage Customers';
    var $addRemoveManageItems='Add, Remove or Manage Items for Sale';
    var $viewReports='View Reports';
    var $configureSettings='Configure Point Of Sale Settings';
    var $viewOnlineSupport='View Online Support';
	/*Home End*/
	
	
	/*Users Home Start*/
	var $createUser='Create a New User';
    var $manageUsers='Manage Users';	
    /*Users Home End*/
	
	
	/*Users Form Start*/
	var $addUser='Add User';
	var $usedInLogin='used in login';
    var $type='Type';
    var $admin='Admin';
    var $salesClerk='Sales Clerk';
    var $reportViewer='Report Viewer';
    var $confirmPassword='Confirm Password';
	/*Users Form End*/


	/*Manage Users Start*/
	var $searchForUser='Search for User (By username)';
  var $searchedForUser='Searched for username';
	var $deleteUser='Delete User';
  var $updateUser='Update User';
	/*Manage Users End*/
	
	
	/*Customers Home Start*/
    var $customersWelcomeScreen='Welcome to the Customers panel!&nbsp;Here you can manage your customers database.&nbsp;You must add one customer before you can process a sale. What would you like to do?';
    var $checkWelcomeScreen='Welcome to the Manage Check panel!&nbsp;Here you can manage your start check number and check printing fields coordinates .&nbsp;What Would you like to do?';
    var $createNewCustomer='Create A New Customer';
    var $manageCustomers='Manage Customers (Sold Item To)';
    var $customersBarcode='Customers Barcode Sheet';
	/*Customers Home End*/
    
    
 	/*Customers Form Start*/
 	var $addCustomer='Add Customer';
    var $firstName='FName';
    var $middleName='MName';
    var $lastName='LName';
    var $licExpDate='LicExpDT';
	var $licState='Lic-State';
	var $idtypeother='ID-Type other';
    var $accountNumber='Account Number';
    var $phoneNumber='Phone';
    var $email='E-Mail';
    var $streetAddress='Street Address';
    var $commentsOrOther='Comments/Other';
 	/*Customers Form End*/
 	
 	
 	/*Manage Customers Start*/
 	var $updateCustomer='Update Customer';
    var $deleteCustomer='Delete Customer';
    var $searchForCustomer='Search for Customer';
    var $searchedForCustomer='Searched for customer';
	var $listOfCustomers='List of Customers';
	/*Manage Customers End*/
	
	/*Manage Add to Inventory Start*/
	var $addtoinventory='Buy & Add to Inventory';
	var $addtoinventoryWelcomeScreen='Welcome to the Buy & Add to Inventory panel!&nbsp;Here you can manage your inventory database.&nbsp;What would you like to do?';
	
	/*Manage Add to Inventory End*/
	
	/*Items Home Start*/
    var $itemsWelcomeScreen='Welcome to the Items panel.&nbsp; Here you manage Items, Brands, Categories and Suppliers.&nbsp; Before you can process a sale, you need to add at least one category, one brand, one supplier, and one item.&nbsp;<br>What would 


you like to do?';
    var $createNewItem='Create a New Item';
    var $manageItems='Manage Items';
    var $manageItems2='Manage Items NEW!';
    var $discountAnItem='Discount an item';
    var $manageDiscounts='Manage Discounts';
    var $itemsBarcode='Items Barcode Sheet';
    var $createBrand='Create a New Brand';
    var $manageBrands='Manage Brands';
    var $createCategory='Create a New Category';
    var $createArticle='Create a New Article';
    var $createArticleType='Create a New Article Type';
    var $manageCategories='Manage Categories';
    var $manageArticles='Manage Articles';
    var $manageArticleTypes='Manage Articles Type';
    var $createSupplier='Create a New Supplier';
    var $manageSuppliers='Manage Suppliers (Buying Item From)';
	/*Items Home End*/	
 	
 	/*Article Form Start*/
 	 var $ActivateArticle='Activate Article';
 	/*Article Form End*/
 	
 	/*Items Form Start*/
 	  var $itemName='Item Name';
    var $description='Description';
    var $itemNumber='Item Number (UPC)';
    var $itemUPC='UPC';
    var $brand='Brand';
    var $category='Category';
    var $supplier='Supplier';
    var $article='Jewelry Type';
    var $articleType='Article Type';
    
    var $gender='Gender';
    var $menitem='Mens Jewelry';
    var $womenitem='Ladies Jewelry';
    var $wg='White Gold (WG)';
    var $yg='Yellow Gold (YG)';
    var $silver='Silver';
    var $other1='Other';
    var $ring='Ring';
    var $pendant='Pendant';
    var $chain='Chain';
    var $bracelet='Bracelet';
    var $charm='Charm';
    var $other2='Other';
    var $kindsize='Kind/Size_Style_of_Stone_Cut';
    var $numstone='Number of Stone';
    var $jewelrydesc='Jewelry Description';
    var $watch='Watch';
    var $watchbrand='Watch Brand';
    var $wristwatch='Wrist';
    var $pocketwatch='Pocket';
    var $watchpendant='Pendant';
    var $lapelwatch='Lapel';
    var $watchserial='Watch Serial';
    var $tv='TV';
    var $stereo='Stereo';
    var $camera='Camera';
    var $musicinst='Musical Instrument';
    var $outboardmotor='Outboard Motor';
    var $snowblower='Snow Blower';
    var $electricaltool='Electrical Tool';
    var $videoequipment='Video Equipment';
    var $typewriter='Typewriter';
    var $computer='Computer';
    var $cdplayer='CD Player';
    var $cbradio='CB Radio';
    var $powermower='Power Mower';
    var $cellphone='Cell Phone';
    var $other3='Other';
    var $serialnumber='Serial#';
    var $brandname='Brand Name';
    var $itemsize='Size';
    var $itemcolor='Color';
    var $itemmodel='Model';
    var $detaildescription='Detail Desc';
    var $dvdtitle='Title';
    var $saleagreement='Create Sale Agreement';
    var $viewsaleagreement='ViewAgreement';
    
    var $buyingPrice='Buying Price';
    var $sellingPrice='Selling Price';
    var $tax='Tax';
    var $supplierCatalogue='Supplier_Catalogue#';
    var $quantityStock='Quantity in Stock';
    var $reorderLevel='Reorder Level';
    var $itemimagelab='Item Image'; 
  	var $users='Users';
    var $itemsInBoldRequired='Items in bold are required';
    var $update='Update';
    var $delete='Delete';
    var $addjewelry='Add Jewelry';
    var $addItem='Buy/Add Items';
	var $addItemtitle='Buy & Add Items to Inventory';
    var $adddvd='Buy & Add Movies to Inventory';
    var $addvdvd='Buy & Add Games to Inventory';
    var $itembarcode='Barcode';
    var $createSaleagreement='CSA';
	var $CreateCheck='Check';
    var $brandsCategoriesSupplierError='You must create brands, categories, and suppliers before creating an item<br><a href=index.php>Back to Items Main</a>';
    var $articlessCategoriesSupplierError='You must create articles, categories, and suppliers before creating an item<br><a href=index.php>Back to Items Main</a>';
    var $finalSellingPricePerUnit='Final Selling Price per Unit';
	/*Items Form End*/
	
	
	/*Manage Items Start*/
	var $updateItem='Update Item';
    var $deleteItem='Delete Item';
    var $searchForItem='Search for Item (By Item Name)';
    var $searchForItemBy='Search for Item';
    var $searchBy='by';
    var $searchedForItem='Searched for item';
    var $listOfItems='List Of Items';
    var $showOutOfStock='Show Out of Stock Items';
    var $outOfStock='Out of Stock Items';
    var $showReorder='Show Items that need to be reordered';
    var $reorder='Items that need to be reordered';
    var $zeroprice='Items that need sale price';
    var $itemDetail='Item Detail';
	/*Manage Items End*/
	
    /*Discount From Start*/
    var $addDiscount='Add Discount';
    var $percentOff='Percent Off';
    var $comment='Comment';
    /*Discount From End*/
    
    
    /*Manage Discounts Start*/
    var $searchForDiscount='Search for discount (By percent off)';
    var $searchedForDiscount='Searched for discount';
    var $listOfDiscounts='List Of Discounts';
    var $updateDiscount='Update Discount';
    var $deleteDiscount='Delete Discount';
    /*Manage Discounts End*/
    
    /*Brands Form Start*/
    var $brandName='Brand Name';
    var $addBrand='Add Brand';
	/*Brands Form End*/
    
    
    /*Manage Brands Start*/
    var $searchForBrand='Search for brand (By brand name)';
    var $searchedForBrand='Searched for brand';
    var $listOfBrands='List Of Brands';
    var $updateBrand='Update Brand';
    var $deleteBrand='Delete Brand';
	/*Manage Brands End*/
    
    
    /*Categories Form Start*/
    var $categoryName='Category Name';
    var $ActivateCategory='Activate Category';
    var $articleName='Article Name';
    var $articleTypeName='Article Type Name';
    var $addCategory='Add Category';
    var $addArticle='Add Article';
    var $addArticleType='Add Article Type';
	/*Categories Form End*/


    /*Manage Categories Start*/
	  var $searchForCategory='Search for category (By category name)';
    var $searchedForCategory='Searched for category';
    var $listOfCategories='List of categories';
    var $updateCategory='Update Category';
    var $deleteCategory='Delete Category';
    
    var $searchForArticle='Search for article (By article name)';
    var $searchForArticleType='Search for article type (By article type name)';
    var $searchedForArticle='Searched for article';
    var $searchedForArticleType='Searched for article type';
    var $listOfArticles='List of articles';
    var $updateArticle='Update Article';
    var $deleteArticle='Delete Article';
    
    var $listOfArticleTypes='List of article types';
    var $updateArticleType='Update Article Type';
    var $deleteArticleType='Delete Article Type';
    /*Manage Categories End*/
    
    
    /*Suppliers Form Start*/
    var $supplierName='Supplier Name';
    
    var $supplierSex='Sex';
    var $vendor='Vendor';
    var $supplierMale='Male';
    var $supplierFemale='Female';
    var $supplierRace='Race';
    var $supplierDOB='DOB';
    var $supplierHeight='Height';
    var $supplierWeight='Weight';
    var $supplierHair='Hair_color';
    var $supplierEyes='Eyes_color';
    
    var $address='Address';
    
    var $city='City';
    var $state='State';
    var $zip='Zip';
    var $licensenum='Driver_Lic#';
    
    var $contact='Contact';
    var $other='Other';
    var $imagefile='Image'; 
	/*Suppliers Form End*/


    /*Manage Suppliers Start*/
    var $listOfSuppliers='List Of Suppliers';
    var $searchForSupplier='Search for supplier (By Phone#)';
    var $searchedForSupplier='Searched for supplier';
    var $addSupplier='Add Supplier';
    var $updateSupplier='Update Supplier';
    var $deleteSupplier='Delete Supplier';
    /*Manage Suppliers End*/


	/*Reports Home Start*/
	var $reportsWelcomeMessage='Welcome to the Reports panel!&nbsp; Here you can view reports based on sales and cost.&nbsp;<br>What would you like to do?';
    var $allCustomersReport='All_Customers_Report';
    var $allEmployeesReport='All_Employees_Report';
    var $allBrandsReport='All_Brands_Report';
    var $allCategoriesReport='All_Categories_Report';
    var $allArticleReport='All_Article_Report';
    var $allArticleTypeReport='All_ArticleType_Report';
    var $allItemsReport='All_Items_Report';
    var $allItemsReportDateRange='All_Items_Report_(DateRange)';
    var $brandReport='Brand_Report';
    var $categoryReport='Category_Report';
    var $jecategoryCostReport='Category_Cost_Report';
    var $customerReport='Customer_Report';
    var $customerReportDateRange='Customer_Report_(DateRange)';
    var $dailyReport='Daily_Report';
    var $dateRangeReport='Date_Range_Report';
    var $employeeReport='Employee_Report';
    var $itemReport='Item_Report';
    var $itemReportDateRange='Item_Report_(DateRange)';
    var $itemCostReportDateRange='Item_CostReport_(DateRange)';
    var $profitReport='Profit_Report';
    var $costReport='Cost_Report';
    var $jeallItemsReportDateRange='Cost Report By Date Range';
    var $taxReport='Tax_Report';
    var $notFound='was not found';
	/*Reports Home End*/
	
	
	/*Input Needed Form Start*/
	var $inputNeeded='Input needed for';
    var $dateRange='Date Range';
    var $today='Today';
    var $yesterday='Yesterday';
    var $last7days='Last 7 Days';
    var $lastMonth='Last Month';
    var $thisMonth='This Month';
    var $thisYear='This Year';
    var $allTime='All Time';
    var $findBrand='Find Brand';
    var $selectBrand='Select Brand';
    var $findCategory='Find Category';
    var $selectCategory='Select Category';
    var $findCustomer='Find Customer';
    var $selectCustomer='Select Customer';
    var $findEmployee='Find Employee';
    var $selectEmployee='Select Employee';
    var $findItem='Find Item';
    var $selectItem='Select Item';
    var $selectTax='Select Tax';
	/*Input Needed Form End*/
    
    
    /*"All" Reports Start*/
		
		/*All Customers Report Start*/
		var $itemsPurchased='Items Purchased';
   		var $moneySpentBeforeTax='Money Spent before tax';
    	var $moneySpentAfterTax='Money Spent after tax';
		var $totalItemsPurchased='Total Items Purchased';
		/*All Customers Report End*/
		
		/*All Brands Report Start*/
		var $totalsForBrands='Totals For Brands';
		/*All Brands Report End*/

		/*All Categories Report Start*/
		var $totalsForCategories='Totals For Categories';
		var $totalsForArticles='Totals For Articles';
		var $totalsForArticleTypes='Totals For Article Types';
		/*All Categories Report End*/

		/*All Employees Report Start*/
		var $totalItemsSold='Total Items Sold';
    	var $moneySoldBeforeTax='Money Sold before tax';
		var $moneySoldAfterTax='Money Sold after tax';
		/*All Employees Report End*/
		
		/*All Items Report Start*/
		var $numberPurchased='Number Purchased';
   		var $subTotalForItem='Sub Total For Item';
        var $totalForItem='Total For Item';
		/*All Items Report End*/
	
	/*"All" Reports End*/
	
	
	/*Other Reports Start*/
	var $paidWith='Paid With';
    var $soldBy='Sold By';
    var $saleDetails='Sale details';
    var $saleSubTotal='Sale Sub Total';
    var $saleTotalCost='Sale Total Cost';
    var $showSaleDetails='Show Sale Details';
    var $listOfSaleBy='List of Sales by';
    var $listOfSalesFor='List Of Sales for';
    var $listOfSalesBetween='List Of Sales<br>between dates';
    var $and='and';
    var $between='between';
    var $totalWithOutTax='Total (w/o Tax)';
    var $totalWithTax='Total (w/ Tax)';
	  var $fromMonth='From Month';
    var $day='Day';
    var $year='Year';
    var $toMonth='To Month';
    var $totalAmountSoldWithOutTax='Total Amount Sold (w/o tax)';
    var $totalCostofItemsWithOutTax='Total Cost of items bought';
    var $profit='Profit';
    var $totalAmountSold='Total Amount Sold';
    var $totalAmountCost='Total Cost Amount';
    var $totalProfit='Total Profit';
    var $totalsShownBetween='Totals shown for sales between';
    var $costtotalsShownBetween='Totals shown for cost between';
    var $totalItemCost='Total Item Cost';
	var $listOfBuyItems='List Of Buy Items';
	/*Other Reports End*/
		
		
	/*Sales Home Start*/
	var $salesWelcomeMessage='Welcome to the Sales panel!&nbsp; Here you can enter sales and manage them.&nbsp;What would you like to do?';
    var $startSale='Start A New Sale';
    var $manageSales='Manage Sales';
	/*Sales Home End*/
	
	
	/*Sale Interface Start*/
    var $yourShoppingCartIsEmpty='Your Shopping Cart is Empty';
    var $addToCart='Add To Cart';
    var $clearSearch='Clear Search';
    var $saleComment='Sale Comment';
    var $addSale='Add Sale';
    var $quantity='Quantity';
    var $remove='Remove';
    var $cash='Cash';
	var $check='Check';
	var $credit='Credit';
	var $giftCertificate='Gift Certificate';
	var $account='Account';
	var $mustSelectCustomer='You must select a customer';
	var $newSale='New Sale';
	var $clearSale='Clear Sale';
	var $newSaleBarcode='New Sale using barcode scanner';
	var $scanInCustomer='Scan in customer';
	var $scanInItem='Scan in item';
	var $shoppingCart='Shopping Cart';
	var $customerID='Customer ID';
	var $itemID='Item ID';
	var $amtTendered='Amt Tendered'; 
    var $amtChange='CHANGE'; 
    var $outOfStockWarn='OUT OF STOCK';
    var $globalSaleDiscount='Global Sale Discount (%)';
	/*Sale Interface End*/
	
	
	/*Sale Receipt Start*/
	var $orderBy='Customer';
	var $itemOrdered='Item Ordered';
	var $extendedPrice='Extended Price';
	var $saleID='Sale ID';
	var $orderFor='Customer';
	/*Sale Receipt End*/


	/*Manage Sales Start*/
	var $searchForSale='Search for Sale (By Sale ID Range)';
	var $searchedForSales='Searched for sales between';
	var $highID='high id';
	var $lowID='low id';
	var $incorrectSearchFormat='Incorect Search Format, please try again';
	var $updateRowID='Update row id';
	var $updateSaleID='Update Sale id';
	var $itemsInSale='Items In Sale';
	var $itemTotalCost='Item Total Cost';
	var $updateSale='Update Sale';
	var $deleteEntireSale='Delete Entire Sale';
	var $customerName='Customer Name';
	var $unitPrice='Unit Price';
	/*Manage Sales End*/
	
	
	/*Config Start*/
	var $configurationWelcomeMessage='Welcome!&nbsp; This is the Configuration panel for Inventory Point of Sale.&nbsp; Here you can modify company information, themes, and other options.&nbsp;Fields in bold are required.';
    var $companyName='Company Name';
    var $fax='Fax';
    var $website='Website';
    var $theme='Theme';
    var $taxRate='Tax Rate';
    var $inPercent='in percent';
    var $currencySymbol='Currency Symbol';
    var $barCodeMode='Bar Code Mode';
    var $language='Language';
    var $storecode='Store Code';
	var $configfile='Config-File';
	var $dvdbuy='DVD Buy Price';
	var $dvdsell='DVD Sell Price';
	var $gamedvdbuy='GameDVD Buy Price';
	var $gamedvdsell='GameDVD Sell Price';
	/*Config End*/
	
	
	/*Error Messages Start*/
	var $youDoNotHaveAnyDataInThe='You do not have any data in the';
    var $attemptedSecurityBreech='Attempted Secuirty breech, you are not a possible user type.';
    var $mustBeAdmin='You must be an Admin to view this page.';
    var $mustBeReportOrAdmin='You must be a Report Viewer or Admin to view this page.';
    var $mustBeSalesClerkOrAdmin='You must be a Sales Clerk or Admin to view this page.';
    var $youMustSelectAtLeastOneItem='You must select at least one Item';
    var $refreshAndTryAgain='Refresh and try again';
	var $noActionSpecified='No action specified! No data was inserted, changed or deleted.';
	var $mustUseForm='You must use the form in order to enter data.';
	var $forgottenFields='You have forgotten one or more of the required fields';
	var $passwordsDoNotMatch='Your passwords do not match!';
	var $logoutConfirm='Are you sure you want to logout?';
	var $usernameOrPasswordIncorrect='username or password are incorrect';
	var $mustEnterNumeric='You must enter a numeric value for price, tax percent, and quantity.';
	var $moreThan='If more than 25 rows in the';
	var $firstDisplayed='table, only the most current 25 rows are displayed per page. Please use the search feature.';
	var $moreThan200='There are more than 200 rows in the';
	var $moreThan25='There are more than 25 rows in the';
	var $first200Displayed='table, only the first 200 rows are displayed. Please use the search feature.';
	var $first25Displayed='table, only the current 25 rows are displayed. Please use the search feature.';
	var $noDataInTable='You do not have any data in the';
	var $table='table';
	var $confirmDelete='Are you sure you want to delete this from the';
	var $invalidCharactor='You have entered an invalid character in one or more of the fields, please hit back and try again';
	var $didNotEnterID='You did not enter an ID';
	var $cantDeleteArticle='You can not delete this article because at least one of your items uses it.';
	var $cantDeleteBrand='You can not delete this brand because at least one of your items uses it.';
	var $cantDeleteCategory='You can not delete this category because at least one of your items uses it.';
	var $cantDeleteCustomer='You can not delete this customer because he/she has purchased at least one item.';
	var $cantDeleteItem='You can not delete this item because it has been purchased at least once.';
	var $cantDeleteSupplier='You can not delete this supplier because at least one of your items uses it.';
	var $cantDeleteUserLoggedIn='You can not delete this user because you are logged in as them!';
	var $cantDeleteUserEnteredSales='You can not delete this user because he/she has entered sales.';
	var $itemWithID='Item with id';
	var $isNotValid='is not valid.';
	var $customerWithID='Customer with id';
	var $configUpdatedUnsucessfully='The configuration file was not updated, please make sure the settings.php file is writeable';
	var $problemConnectingToDB='There was a problem connecting to the database,<br> please hit back and verify your settings.';
	/*Error Messages End*/
    
    
    /*Success Messages Start*/
	var $upgradeMessage='Clicking submit will upgrade the database to version 9.0.  You must have version 7.0 or greater to upgrade Inventory Point Of Sale.';
	var $upgradeSuccessfullMessage='Inventory Point Of Sale\'s database has been successfully upgraded to version 9.0, please delete the upgrade and install folders for security purposes.';
	var $successfullyAdded='You have succesfully added this in table';
	var $successfullyUpdated='You have succesfully updated this in table';
	var $successfullyDeletedRow='You have succesfully deleted row linked to ID';
	var $successfullyDeletedRowandpics='You have succesfully deleted row and picture linked to ID';
	var $fromThe='from the';
	var $configUpdatedSuccessfully='The configuration file was updated successfully';
	var $installSuccessfull='The installation of Inventory Point Of Sale was successfull,<br> please click <a href=../login.php>here</a> to login and get started!';
	/*Success Messages End*/



	var $databaseServer='Database Server';
	var $databaseName='Database Name';
	var $databaseUsername='Database Username';
	var $databasePassword='Database Password';
	var $mustExist='Must Exist';
	var $defaultTaxRate='Default Tax Rate';
	var $tablePrefix='Table Prefix';
	var $numberToUseForBarcode='Property to use when scanning barcodes at sale';
	var $whenYouFirstLogIn='Important, when you first login your username is';
	var $yourPasswordIs='your password is';
	var $install='Install';
	var $bigBlue='Big Blue';
	var $percent='Percent';

	
	
	/*Generic Start*/
    var $name='Name';
    var $customer='Customer';
    var $employee='Employee';
    var $date='Date';
    var $rowID='Row ID';
    var $field='Field';
	var $data='Data';
	var $quantityPurchased='Quantity Purchased';
	var $listOf='List Of';
	var $wo='w/o';
	/*Generic End*/
    
}	

?>
