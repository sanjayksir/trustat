// ------------------------------------------------------------------------------------------
// General apiDoc documentation blocks and old history blocks.
// ------------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------------------
// Current Success.
// ------------------------------------------------------------------------------------------


// ------------------------------------------------------------------------------------------
// Current Errors.
// ------------------------------------------------------------------------------------------
/**
 @apiDefine UserError
 @apiVersion 0.1.0

 @apiError status false.
 @apiError message api error as per request.
 @apiError errors validation errors.

 @apiErrorExample  Response (example):
     HTTP/1.1 400 Bad Request
     {
        "status":false,
        "message": "Bad request"
     }
*/
/**
 @apiDefine ProductError
 @apiVersion 0.1.0

 @apiError status false.
 @apiError message api error as per request like record not found or validation errors.
 @apiError errors validation errors.

 @apiErrorExample  Response (example):
     HTTP/1.1 400 Bad Request
     {
        "status":false,
        "message": "Bad request"
     }
*/

