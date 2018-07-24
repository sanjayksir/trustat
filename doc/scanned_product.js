/**
 * @api {post} /scan-product Scan Product
 * @apiVersion 0.1.0
 * @apiName PostScannedProduct
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Scan product with barcode and retrieve the product details. content-type must be application/json in header request.
 *
 * @apiHeader {String} token token must be set in header. 
 * 
 * @apiParam {String} bar_code Barcode of product to scan. (Required).
 * @apiParam {String} latitude Latitude from where product scanned. (Required).
 * @apiParam {String} longitude Longitude from where product scanned (Required).
 *
 * @apiExample Example usage:
 *
    {
        "bar_code":"prosinc-9538-0000-72-1",
        "latitude":"33333.3333",
        "longitude":"33.333333"
    }
 *
 *
 * @apiSuccess {String} status true.
 * @apiSuccess {String} message Scanned product details.
 * @apiSuccess {Object} data Product details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "Scanned product details.",
    "data": {
        "id": "72",
        "product_name": "FTLOverNight-Gold001",
        "attribute_list": [
            {
                "name": "Type",
                "value": "tt1.1.15555"
            }
        ],
        "industry_data": [
            {
                "industry": "Logistics"
            }
        ],
        "created_date": "2018-02-02 17:33:32",
        "created_by": "199",
        "status": "1",
        "product_sku": "ftlovernight-gold001-2157",
        "product_description": "",
        "product_images": "",
        "product_video": "",
        "product_audio": "",
        "product_pdf": "",
        "code_type": "qrcode",
        "code_activation_type": "Pre-Activated",
        "delivery_method": "1",
        "code_key_type": "serial",
        "code_size": "S",
        "other_industry": ""
    }
}
 *
 * @apiUse ProductError
 */
function PostScannedProduct() { return; }
/**
 * @api {get} /view-scanned-product View Scanned List
 * @apiVersion 0.1.0
 * @apiName GetScannedProduct
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription View Scan product with barcode and relative product details of logged user.
 *
 * @apiHeader {String} token token must be set in header. 
 *
 * @apiSuccess {String} status true.
 * @apiSuccess {String} message Scanned product details.
 * @apiSuccess {Object} data Product details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "Scanned product details.",
    "data": [
        {
            "product_id": "72",
            "bar_code": "prosinc-9538-0000-72-1",
            "latitude": "33333.3333",
            "longitude": "33.333333",
            "created_at": "2018-02-25 20:51:45",
            "product_name": "FTLOverNight-Gold001",
            "product_sku": "ftlovernight-gold001-2157",
            "product_description": "",
            "attribute_list": [
                {
                    "name": "Type",
                    "value": "tt1.1.15555"
                }
            ],
            "industry_data": [
                {
                    "industry": "Logistics"
                }
            ],
            "product_images": "",
            "product_video": "",
            "product_audio": "",
            "product_pdf": ""
        },
        {
            "product_id": "72",
            "bar_code": "prosinc-9538-0000-72-1",
            "latitude": "33333.3333",
            "longitude": "33.333333",
            "created_at": "2018-02-25 21:26:41",
            "product_name": "FTLOverNight-Gold001",
            "product_sku": "ftlovernight-gold001-2157",
            "product_description": "",
            "attribute_list": [
                {
                    "name": "Type",
                    "value": "tt1.1.15555"
                }
            ],
            "industry_data": [
                {
                    "industry": "Logistics"
                }
            ],
            "product_images": "",
            "product_video": "",
            "product_audio": "",
            "product_pdf": ""
        }
    ]
}
 *
 * @apiUse ProductError
 */
function GetScannedProduct() { return; }
/**
 * @api {post} /register-product My Product Registration
 * @apiVersion 0.1.0
 * @apiName PostRegisterProduct
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Register the puchased product with following details. content-type must be application/json in header request and requested data must in form-data.
 *
 * @apiHeader {String} token token must be set in header. 
 * 
 * @apiParam {String} bar_code Barcode of product to scan. (Required).
 * @apiParam {Date} purchase_date Purchased date. (Required).
 * @apiParam {String} invoice Ivoice of purchased product (Required).
 * @apiParam {Array} invoice_image Ivoice image and must in format any one (png|gpeg|gpg|pdf) (Required).
 * @apiParam {Date} expiry_date Product expiry date (Required).
 *
 * @apiSuccess {String} status true.
 * @apiSuccess {String} message Product has been registered.
 * @apiSuccess {Object} data Input details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "Product has been registered.",
    "data": {
        "bar_code": "prosinc-9538-0000-72-1",
        "invoice": "#kdlskl3343",
        "expiry_date": "2018-02-02",
        "invoice_image": "http://localhost/tracking/uploads/invoice/profile28.jpg",
        "ordered_date": "2018-02-02",
        "consumer_id": "9"
    }
}
 *
 * @apiUse ProductError
 */
function PostRegisterProduct() { return; }
/**
 * @api {get} /purchased-product My Product List
 * @apiVersion 0.1.0
 * @apiName GetPurchasedProduct
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Get list of all purchased products detail. content-type must be application/json in header request.
 *
 * @apiHeader {String} token token must be set in header. 
 *
 * @apiSuccess {String} status true.
 * @apiSuccess {String} message List of purchased products.
 * @apiSuccess {Object} data List of products.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of purchased products.",
    "data": [
        {
            "bar_code": "lifehinc-7034-0000-64-2",
            "purchased_id": "3",
            "purchased_date": "2018-02-02 00:00:00",
            "invoice": "#kdlskl3343",
            "expiry_date": "2018-02-02",
            "invoice_image": "http://localhost/tracking/uploads/invoice/profile210.jpg",
            "product_id": "72",
            "product_name": "FTLOverNight-Gold001",
            "product_sku": "ftlovernight-gold001-2157",
            "product_description": "",
            "attribute_list": [
                {
                    "name": "Type",
                    "value": "tt1.1.15555"
                }
            ],
            "industry_data": [
                {
                    "industry": "Logistics"
                }
            ],
            "product_images": "",
            "product_video": "",
            "product_audio": "",
            "product_pdf": ""
        }
    ]
}
 *
 * @apiUse ProductError
 */
function GetPurchasedProduct() { return; }
/**
 * @api {get} /product-details/:product_id Warranty Status
 * @apiVersion 0.1.0
 * @apiName GetProductDetails
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Get purchased products detail. content-type must be application/json in header request.
 *
 * @apiHeader {String} token token must be set in header. 
 *
 * @apiSuccess {String} status true.
 * @apiSuccess {String} message List of purchased products.
 * @apiSuccess {Object} data List of products.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of purchased products.",
    "data": {
            "bar_code": "lifehinc-7034-0000-64-2",
            "purchased_id": "3",
            "ordered_date": "2018-02-02 00:00:00",
            "invoice": "#kdlskl3343",
            "expiry_date": "2018-02-02",
            "invoice_image": "http://localhost/tracking/uploads/invoice/profile210.jpg",
            "product_id": "72",
            "product_name": "FTLOverNight-Gold001",
            "product_sku": "ftlovernight-gold001-2157",
            "product_description": "",
            "attribute_list": [
                {
                    "name": "Type",
                    "value": "tt1.1.15555"
                }
            ],
            "industry_data": [
                {
                    "industry": "Logistics"
                }
            ],
            "product_images": "",
            "product_video": "",
            "product_audio": "",
            "product_pdf": ""
    }
}
 *
 * @apiUse ProductError
 */
function GetProductDetails() { return; }
/**
 * @api {post} /complaint Complaint Log
 * @apiVersion 0.1.0
 * @apiName PostComplaint
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Log your complain regarding purchased product. content-type must be application/json in header.
 *
 * @apiHeader {String} token token must be set in header. 
 * 
 * @apiParam {Integer} bar_code product bar code. (Required).
 * @apiParam {String} type Complaint type. (Required).
 * @apiParam {String} description Describe the message want to convey (Required).
 * 
 * @apiExample Example usage:
    {
        "bar_code":"lifehinc-7034-0000-64-2",
        "type":"complaint type",
        "description":"Product is not working."
    }

 * @apiSuccess {String} status true.
 * @apiSuccess {String} message Your complain has been logged successfully.
 * @apiSuccess {Object} data Input details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "Your complain has been logged successfully.",
    "data": {
        "bar_code": "lifehinc-7034-0000-64-2",
        "type": "product related",
        "description": "one two",
        "created_at": "2018-03-02 07:58:29",
        "consumer_id": "9",
        "complain_code": "085374",
        "status": "pending"
    }
}
 *
 * @apiUse ProductError
 */
function PostComplaint() { return; }
/**
 * @api {post} /feedback-answer Feedback Answer
 * @apiVersion 0.1.0
 * @apiName PostFeedbackAnswer
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Save the consumer feedback answer.
 *
 * @apiHeader {String} token token must be set in header. 
 * 
 * @apiParam {Integer} product_id Purchased product id. (Required).
 * @apiParam {Integer} question_id Purchased product id. (Required).
 * @apiParam {String} product_qr_code product qr code. (Required).
 * @apiParam {String} selected_answer answer selected by consumer. (Required).
 * 
 * @apiExample Example usage:
{
	"product_id":142,
        "product_qr_code":"8767yttrerr142",
	"question_id":223,
	"selected_answer":"answer3"
}

 * @apiSuccess {String} status true.
 * @apiSuccess {String} message Feedback answer has been saved successfully.
 * @apiSuccess {Object} data Input details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "Feedback answer has been saved successfully.",
    "data": {
        "product_id": 142,
        "question_id": 2,
        "selected_answer": "answer3",
        "user_id": "2",
        "updated_date": "2018-04-27 10:56:39",
        "created_date": "2018-04-27 10:56:39"
    }
}
 *
 * @apiUse ProductError
 */
function PostFeedbackAnswer() { return; }
/**
 @api {get} /feedback-question/(:product_id) Feedback Question
  @apiVersion 0.1.0
  @apiName getFeedbackQuestion
  @apiGroup Product
  @apiPermission Private user
 
  @apiDescription List of feedback question related to product.

  @apiHeader {String} token token must be set in header. 
 
  @apiParam {Integer} product_id existing product id (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message List of questions for feedback.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of questions for feedback.",
    "data": [
        {
            "question_id": "5",
            "question": "Q1",
            "question_type": "",
            "answer1": "opt1",
            "answer2": "opt2",
            "answer3": "opt3",
            "answer4": "opt4",
            "correct_answer": "2"
        }
    ]    
}
  @apiUse UserError
*/
function getFeedbackQuestion() { return; }
/**
 * @api {post} /redemption/add New Redemption
 * @apiVersion 0.1.0
 * @apiName PostRedemptionAdd
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Save the consumer redemption.
 *
 * @apiHeader {String} token token must be set in header. 
 * 
 * @apiParam {Integer} aadhaar_number Purchased product id. (Required).
 * @apiParam {Integer} alternate_mobile_no Purchased product id. (Required).
 * @apiParam {String} street_address product qr code. (Required).
 * @apiParam {String} city answer selected by consumer. (Required).
 * @apiParam {String} state answer selected by consumer. (Required).
 * @apiParam {String} pin_code answer selected by consumer. (Required).
 * @apiParam {String} points_redeemed answer selected by consumer. (Required).
 * @apiParam {String} city answer selected by consumer. (Required).
 * @apiParam {String} coupon_number answer selected by consumer. (Required).
 * @apiParam {String} coupon_type answer selected by consumer. (Required).
 * @apiParam {String} coupon_vendor answer selected by consumer. (Required).
 * @apiParam {String} courier_details answer selected by consumer. (Required).
 * 
 * @apiExample Example usage:
{
	"aadhaar_number":"7876543456789876",
	"alternate_mobile_no":"8765456",
	"street_address":"pocket c1, Mayurvihar phase 3",
	"city":"New Delhi",
	"state":"Delhi",
	"pin_code":"110096",
	"points_redeemed":"20",
	"coupon_number":"9889",
	"coupon_type":"xyss",
	"coupon_vendor":"tracking",
	"courier_details":""
}

 * @apiSuccess {String} status true.
 * @apiSuccess {String} message Thank you for your redemption request, after validation, your request will be processed in next 7-10 Working days..
 * @apiSuccess {Object} data Input details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "Thank you for your redemption request, after validation, your request will be processed in next 7-10 Working days."
}
 *
 * @apiUse ProductError
 */
function PostRedemptionAdd() { return; }
/**
 * @api {get} /redemption View Redemption List
 * @apiVersion 0.1.0
 * @apiName GetRedemption
 * @apiGroup Product
 * @apiPermission required
 *
 * @apiDescription Get the list of redemption.
 *
 * @apiHeader {String} token token must be set in header. 
 *
 * @apiSuccess {String} status true.
 * @apiSuccess {String} message List of redemption.
 * @apiSuccess {Object} data Redemption List.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of redemption",
    "data": [
        {
            "aadhaar_number": "7876543456789876",
            "alternate_mobile_no": "8765456",
            "city": "New Delhi",
            "state": "Delhi",
            "street_address": "pocket c1, Mayurvihar phase 3",
            "pin_code": "110096",
            "points_redeemed": "20",
            "coupon_number": "9889",
            "coupon_type": "xyss",
            "coupon_vendor": "tracking",
            "courier_details": ""
        }
    ]    
}
 *
 * @apiUse ProductError
 */
function GetRedemption() { return; }