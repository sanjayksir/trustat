/**
 * @api {post} /register Register User
 * @apiVersion 0.1.0
 * @apiName PostUser
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Create a new account. Register new user with below following parameters.content-type must be application/json in header request.
 *
 * @apiParam {String} user_name Username size between 4-50 charecters (Required).
 * @apiParam {String} email Email of user must be unique (Required).
 * @apiParam {Date}   dob Date of birth must in in format YYYY-DD-MM (Required).
 * @apiParam {String} gender Gender of user like any one (male, femal) (Required).
 * @apiParam {Number} mobile_no Mobile no of user and accept only 10 digits only and must be unique(Required).
 * @apiParam {Bool} terms_conditions Terms and conditions  (Required).
 *
 * @apiExample Example usage:
 *
    {
        "user_name":"devtest",
        "email":"devtest@gmail.com",
        "mobile_no":"9343233787",
        "gender":"male",
        "dob":"2000-2-2",
        "terms_conditions":"0"
    }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Registration done successfully.
 * @apiSuccess {Object} data List of user details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
 {
    "status": true,
    "message": "Your account has been created.",
    "data": {
        "user_name": "dev test",
        "email": "dev.test@gmail.com",
        "mobile_no": "9343233781",
        "gender": "male",
        "dob": "2000-2-2",
        "terms_conditions": "1"
        "created_at": "2018-02-11 17:47:39",
        "modified_at": "2018-02-11 17:47:39"
    }
}
 *
 * @apiUse UserError
 */
function postUser() { return; }
/**
 @api {post} /login Login
  @apiVersion 0.1.0
  @apiName PostLogin
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription User login with user name and its password.User get logged in by using username and password including device_id.content-type must be application/json in header request.
 
  @apiParam {String} username Either registered email or mobile no (Required).
  @apiParam {String} password secret password (Required).
  @apiParam {String} device_id Device personal id (Required).
 
  @apiExample Example usage: 
    {
       "username": "devtest@gmail.com/9887876767",
       "password": "XXXXXXXXX",
       "device_id":"DATEOSDEVICEIP"
    }
 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Login done successfully.
  @apiSuccess {Object} data List of user details.
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
            "avatar_url": "http://domain.com/uploads/consumer/abc.png",
            "id": "1",
            "token": "ebd65aa7817b650ad78b2b68f989c742"
        }
    }
  @apiError {String} Sign in credentials ain't right, try again buddy.
  @apiUse UserError
*/
function postLogin() { return; }
/**
 @api {post} /verifyotp Verifyotp
  @apiVersion 0.1.0
  @apiName PostVerifyotp
  @apiGroup User
  @apiPermission Public user
 
  @apiDescription Verify One time password. content-type must be application/json in header request.
 
  @apiParam {Integer} mobile_no Registered Mobile no (Required).
  @apiParam {Integer} otp One time password sent on mobile (Required).
 
  @apiExample Example usage: 
    {
        "mobile_no":"9716322021",
        "otp":"819124"
    } 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Your account has been successfully verified.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "Your account has been successfully verified."
    }
  @apiUse UserError
*/
function postVerifyotp() { return; }
/**
 @api {get} /resendotp/(:mobile_no) Resendotp
  @apiVersion 0.1.0
  @apiName GetResendotp
  @apiGroup User
  @apiPermission Public user
 
  @apiDescription Resend One time password.
 
  @apiParam {Integer} mobile_no Registered Mobile no (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message OTP has been sent successfully.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "OTP has been sent successfully."
    }
  @apiUse UserError
*/
function getresendotp() { return; }
/**
 @api {post} /resendmail Resend Mail
  @apiVersion 0.1.0
  @apiName PostResendmail
  @apiGroup User
  @apiPermission Public user
 
  @apiDescription Resend mail to verify email.
 
  @apiParam {String} email Registered Email id (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Mail has been sent successfully.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "Mail has been sent successfully."
    }
  @apiUse UserError
*/
function postResendmail() { return; }
/**
 @api {get} /logout Logout
  @apiVersion 0.1.0
  @apiName GetLogout
  @apiGroup User
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
 @api {get} /forgot-password/(:mobile_no|:email) Forgot Password
  @apiVersion 0.1.0
  @apiName GetForgot-password
  @apiGroup User
  @apiPermission Public user
 
  @apiDescription To change the forgotten password.
 
  @apiParam {Integer} mobile_no|email Any one registered Mobile no or email (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message A new password has been sent to your registered mobile no.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "A new password has been sent to your registered mobile no."
    }
  @apiUse UserError
*/
function getforgotPassword() { return; }
/**
 @api {post} /change-password Change password
  @apiVersion 0.1.0
  @apiName PostChange-password
  @apiGroup User
  @apiPermission Only logged in user
 
  @apiDescription Change the existing password.Request must be in json.
  
  @apiHeader {String} token Token must be in header.
 
  @apiParam {String} old_password Existing password (Required).
  @apiParam {String} new_password new password (Required).
  @apiParam {String} confirm_password repeat the new password (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message New password has been changed successfully.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "New password has been changed successfully."
    }
  @apiUse UserError
*/
function postChangePassword() { return; }
/**
 @api {post} /user/edit Edit profile
  @apiVersion 0.1.0
  @apiName PostEdit
  @apiGroup User
  @apiPermission Only logged in user
 
  @apiDescription update profile details.
  
  @apiHeader {String} token Token must be in header.
 
  @apiParam {String} user_name user name (Required).
  @apiParam {String} gender must be any one male|female(Required).
  @apiParam {String} dob date of birth in format YYYY-mm-dd (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Your account has been updated.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "Your account has been updated.",
        "data": {
            "user_name": "devtest",
            "gender": "male",
            "dob": "1988-2-2"
        }
    }
  @apiUse UserError
*/
function postEdit() { return; }
/**
 @api {get} /user/view View Profile
  @apiVersion 0.1.0
  @apiName GetView
  @apiGroup User
  @apiPermission Logged in user
 
  @apiDescription To view profile details.
  @apiHeader {String} token Token must be in header.
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Your account details..
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
        "status": true,
        "message": "Your account details.",
        "data": {
            "id": "1",
            "user_name": "devtest",
            "email": "devtest@gmail.com",
            "password": "999ca51334ef2896b0c10707a278cb29",
            "mobile_no": "9716322087",
            "gender": "male",
            "dob": "1988-02-02",
            "ip": "::1",
            "is_verified": "1",
            "verification_code": "997453",
            "status": "inactive",
            "terms_conditions": "0",
            "created_at": "2018-02-16 15:42:10",
            "modified_at": "2018-02-19 22:19:14"
        }
    }
  @apiUse UserError
*/
function getView() { return; }
/**
 @api {post} /upload-avatar Upload Profile Image
  @apiVersion 0.1.0
  @apiName postUploadAvatar
  @apiGroup User
  @apiPermission Private user
 
  @apiDescription Upload profile image.Image mime type must be image/png,image/gif and image/jpg and size below 4MB.Data must be sent in form-data format on HTTP.
 
  @apiHeader {String} token * Token must be in header.

  @apiParam {Object} avatar * Profile Image object (Required).
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message Image has been uploaded successfully.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
    {
    "status": true,
    "message": "Image has been uploaded successfully.",
    "data": {
        "avatar_url": "http://domain.com/uploads/consumer/profile11.jpg"
    }
}
  @apiUse UserError
*/
function postUploadAvatar() { return; }
/**
 @api {get} /loylties List of loylties
  @apiVersion 0.1.0
  @apiName getLoylties
  @apiGroup Product
  @apiPermission Private user
 
  @apiDescription List of loylties.

  @apiHeader {String} token token must be set in header. 
 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message List of loylties.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of loylties.",
    "data": [
        {
            "id": "1",
            "transaction_type": "User Registration",
            "points": "100",
            "customer": null,
            "product": null,
            "status": "1",
            "created_at": "2018-05-12 00:00:00",
            "modified_at": "2018-05-12 00:00:00"
        }
    ]
}
  @apiUse UserError
*/
function getLoylties() { return; }
/**
 @api {get} /consumer-loylty Consumer loylties
  @apiVersion 0.1.0
  @apiName getConsumerLoylty
  @apiGroup Product
  @apiPermission Private user
 
  @apiDescription List of consumer earn loylties.

  @apiHeader {String} token token must be set in header. 
 
 
  @apiSuccess {String} status true.
  @apiSuccess {String} message User gain loylties.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": true,
    "message": "List of loylties.",
    "data": [
        {
            "id": "1",
            "user_id": "2",
            "points": "8",
            "transaction_type": "Product Registration with Warranty",
            "params": {
                "product_id": 21
            },
            "date_expire": "2018-08-13 13:09:44",
            "created_at": "2018-05-13 13:09:44",
            "modified_at": "2018-05-13 13:09:44"
        },
        {
            "id": "2",
            "user_id": "2",
            "points": "6",
            "transaction_type": "Scan for Genuity and pdf Response",
            "params": {
                "product_id": 142,
                "question_id": "2"
            },
            "date_expire": "2018-08-13 13:13:36",
            "created_at": "2018-05-13 13:13:36",
            "modified_at": "2018-05-13 13:13:36"
        },
        {
            "id": "3",
            "user_id": "2",
            "points": "8",
            "transaction_type": "Product Registration with Warranty",
            "params": {
                "product_id": 22
            },
            "date_expire": "2018-08-14 08:57:18",
            "created_at": "2018-05-14 08:57:18",
            "modified_at": "2018-05-14 08:57:18"
        }
    ]
}
  @apiUse UserError
*/
function getConsumerLoylty() { return; }