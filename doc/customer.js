/**
  @api {post} /customer/login Login
  @apiVersion 0.1.0
  @apiName PostLogin
  @apiGroup Customer App
  @apiPermission Private User
 
  @apiDescription User login with user name and its password.User get logged in by using username and password including device_id.content-type must be application/json in header request.
 
  @apiParam {String} username Either registered email or username (Required).
  @apiParam {String} password secret password (Required).
  @apiParam {String} device_id Device personal id (Required).
 
  @apiExample Example usage: 
    {
       "username": "devtest@gmail.com|devtest",
       "password": "XXXXXXXXX",
       "device_id":"DATEOSDEVICEIP"
    }
 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Login done successfully.
  @apiSuccess {Object} data User details.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "Login successfully.",
        "data": {
            "user_name": "dev test",
            "email": "devtest@gmail.com",
            "gender": "male",
            "dob": "2000-02-02",
            "mobile_no": "9343233787",
            "id": "1",
            "token": "ebd65aa7817b650ad78b2b68f989c742"
        }
    }
  @apiError {String} Sign in credentials ain't right, try again buddy.
  @apiUse UserError
*/
function postLogin() { return; }
/**
 @api {get} /customer/logout Logout
  @apiVersion 0.1.0
  @apiName GetLogout
  @apiGroup Customer App
  @apiPermission Registered User only
 
  @apiDescription Get logout to the logged in user.Token must be in header.
  @apiHeader {String} token Token must be in header.

  @apiSuccess {String} status true.
  @apiSuccess {String} message Logout successfully.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "Logout successfully."
    }
  @apiUse UserError
*/
function getLogout() { return; }
/**
  @api {post} /customer/add-product-level Add Product Level
  @apiVersion 0.1.0
  @apiName postAddProductLevel
  @apiGroup Customer App
  @apiPermission Private User
 
  @apiDescription Add product level and make product active with the help of barcode.
 
  @apiParam {String} bar_code Product bar code (Required).
  @apiParam {String} pack_level Scanned product level (Required).
 
  @apiExample Example usage: 
    {
        "bar_code":"prosinc-9538-0000-72-2,lifehinc-7034-0000-64-25",
        "pack_level":"4",
        "plant_id":"xxxx"
    }
 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Level has been added.
  @apiSuccess {Object} data scanned product details.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
  {
    "status": true,
    "message": "Level has been added.",
    "data": [
    {
        "id": "93",
        "product_name": "ProsInc",
        "attribute_list": [
            {
                "name": "Size",
                "value": "6"
            },
            {
                "name": "Colour",
                "value": "Green"
            },
            {
                "name": "Type",
                "value": "tt1.1.15555"
            }
        ],
        "industry_data": [
            {
                "industry": "Financials"
            }
        ],
        "created_date": "2018-02-23 16:28:59",
        "created_by": "217",
        "status": "1",
        "product_sku": "prosinc-9538",
        "product_description": "Financial Product",
        "product_images": [
            "http://localhost/tracking/uploads/tmp/5a8ff413bb61e.png",
            "http://localhost/tracking/uploads/tmp/5a8ff41454b9e.png",
            "http://localhost/tracking/uploads/tmp/5a8ff4148840f.png",
            "http://localhost/tracking/uploads/tmp/5a8ff414b993f.png"
        ],
        "product_video": [
            "http://localhost/tracking/uploads/tmp/video_12_1519383597172.mp4"
        ],
        "product_audio": [
            "http://localhost/tracking/uploads/tmp/sampleaudio_file-1519383638.mp3"
        ],
        "product_pdf": [
            "http://localhost/tracking/uploads/tmp/brochure2-1519383631.pdf",
            "http://localhost/tracking/uploads/tmp/brochure4-1519383636.pdf",
            "http://localhost/tracking/uploads/tmp/brochure3-1519383636.pdf",
            "http://localhost/tracking/uploads/tmp/brochure1-1519383637.pdf"
        ],
        "code_type": "qrcode",
        "code_activation_type": "Pre-Activated",
        "delivery_method": "3",
        "code_key_type": "random",
        "code_size": "M",
        "other_industry": "",
        "pbq_id": "28",
        "active_status": "0",
        "pack_level": null,
        "barcode_qr_code_no": "prosinc-9538-0000-72-2"
        }
    ]
}
  @apiError {String} Product has been already activated.
  @apiUse UserError
*/
function postAddProductLevel() { return; }
/**
  @api {post} /customer/view-product?offset=:offset&limit=:limit View Products
  @apiVersion 0.1.0
  @apiName viewProducts
  @apiGroup Customer App
  @apiPermission Private User
 
  @apiDescription View list of products.Use offset and limit to use pagination other it will retrieve 50 recrods at a time.
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Level has been added.
  @apiSuccess {Object} data scanned product details.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of products",
    "data": [
        {
            "pack_level": "Test",
            "bar_code": "lifehinc-7034-0000-64-1",
            "active_status": "1",
            "product_id": "91",
            "product_name": "Lifehinc",
            "product_sku": "lifehinc-7034",
            "product_description": "",
            "attribute_list": [
                {
                    "name": "Weight",
                    "value": "100 GM"
                },
                {
                    "name": "Type",
                    "value": "tt1.1.15555"
                },
                {
                    "name": "Heights",
                    "value": "1 Feet"
                },
                {
                    "name": "Heights",
                    "value": "2 Feet"
                },
                {
                    "name": "Heights",
                    "value": "3 Feet"
                },
                {
                    "name": "Heights",
                    "value": "4 Feet"
                },
                {
                    "name": "Weight",
                    "value": "2 Kg"
                },
                {
                    "name": "Weight",
                    "value": "3 Kg"
                }
            ],
            "industry_data": [
                {
                    "industry": "Financials"
                }
            ],
            "product_images": "",
            "product_video": "",
            "product_audio": "",
            "product_pdf": ""
        }
    ]
}
  @apiError {String} Product has been already activated.
  @apiUse UserError
*/
function viewProducts() { return; }
/**
  @api {post} /customer/add-inventory Add Physical Inventory
  @apiVersion 0.1.0
  @apiName postAddInventory
  @apiGroup Customer App
  @apiPermission Private User
 
  @apiDescription Add physical inventory.
 
  @apiParam {String} bar_code Product bar code (Required).
  @apiParam {String} plant_id Plant code (Required).
 
  @apiExample Example usage: 
    {
        "bar_code":"prosinc-9538-0000-72-2",
        "plant_id":"xxxx"
    }
 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Level has been added.
  @apiSuccess {Object} data scanned product details.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
  {
    "status": true,
    "message": "Inventory has been created successfully."
}
  @apiError {String} Product has been already activated.
  @apiUse UserError
*/
function postAddInventory() { return; }
/**
  @api {post} /customer/view-inventory?offset=:offset&limit=:limit View Inventory
  @apiVersion 0.1.0
  @apiName viewInventory
  @apiGroup Customer App
  @apiPermission Private User
 
  @apiDescription View Inventory.
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message List of product inventory.
  @apiSuccess {Object} data Inventory details.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of product inventory",
    "data": [
        {
            "inventory_id": "1",
            "plant_id": "8998989",
            "created_at": "2018-03-22 09:30:42",
            "pack_level": "3",
            "bar_code": "prosinc-9538-0000-72-2",
            "active_status": "1",
            "product_id": "93",
            "product_name": "ProsInc",
            "product_sku": "prosinc-9538",
            "product_description": "Financial Product",
            "attribute_list": [
                {
                    "name": "Size",
                    "value": "6"
                },
                {
                    "name": "Colour",
                    "value": "Green"
                },
                {
                    "name": "Type",
                    "value": "tt1.1.15555"
                }
            ],
            "industry_data": [
                {
                    "industry": "Financials"
                }
            ],
            "product_images": [
                "http://localhost/tracking/uploads/tmp/5a8ff413bb61e.png",
                "http://localhost/tracking/uploads/tmp/5a8ff41454b9e.png",
                "http://localhost/tracking/uploads/tmp/5a8ff4148840f.png",
                "http://localhost/tracking/uploads/tmp/5a8ff414b993f.png"
            ],
            "product_video": [
                "http://localhost/tracking/uploads/tmp/video_12_1519383597172.mp4"
            ],
            "product_audio": [
                "http://localhost/tracking/uploads/tmp/sampleaudio_file-1519383638.mp3"
            ],
            "product_pdf": [
                "http://localhost/tracking/uploads/tmp/brochure2-1519383631.pdf",
                "http://localhost/tracking/uploads/tmp/brochure4-1519383636.pdf",
                "http://localhost/tracking/uploads/tmp/brochure3-1519383636.pdf",
                "http://localhost/tracking/uploads/tmp/brochure1-1519383637.pdf"
            ]
        }
    ]
}
  @apiUse UserError
*/
function viewInventory() { return; }