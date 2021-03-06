define({ "api": [
  {
    "type": "get",
    "url": "/customer/logout",
    "title": "Logout",
    "version": "0.1.0",
    "name": "GetLogout",
    "group": "Customer_App",
    "permission": [
      {
        "name": "Registered User only"
      }
    ],
    "description": "<p>Get logout to the logged in user.Token must be in header.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Logout successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Logout successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/customer.js",
    "groupTitle": "Customer_App",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/customer/logout"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/customer/login",
    "title": "Login",
    "version": "0.1.0",
    "name": "PostLogin",
    "group": "Customer_App",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>User login with user name and its password.User get logged in by using username and password including device_id.content-type must be application/json in header request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>Either registered email or username (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>secret password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<p>Device personal id (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage: ",
        "content": "{\n   \"username\": \"devtest@gmail.com|devtest\",\n   \"password\": \"XXXXXXXXX\",\n   \"device_id\":\"DATEOSDEVICEIP\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Login done successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>User details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Login successfully.\",\n    \"data\": {\n        \"user_name\": \"dev test\",\n        \"email\": \"devtest@gmail.com\",\n        \"gender\": \"male\",\n        \"dob\": \"2000-02-02\",\n        \"mobile_no\": \"9343233787\",\n        \"id\": \"1\",\n        \"token\": \"ebd65aa7817b650ad78b2b68f989c742\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Sign",
            "description": "<p>in credentials ain't right, try again buddy.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/customer.js",
    "groupTitle": "Customer_App",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/customer/login"
      }
    ]
  },
  {
    "type": "post",
    "url": "/customer/add-inventory",
    "title": "Add Physical Inventory",
    "version": "0.1.0",
    "name": "postAddInventory",
    "group": "Customer_App",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Add physical inventory.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bar_code",
            "description": "<p>Product bar code (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "plant_id",
            "description": "<p>Plant code (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage: ",
        "content": "{\n    \"bar_code\":\"prosinc-9538-0000-72-2\",\n    \"plant_id\":\"xxxx\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Level has been added.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>scanned product details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n  {\n    \"status\": true,\n    \"message\": \"Inventory has been created successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Product",
            "description": "<p>has been already activated.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/customer.js",
    "groupTitle": "Customer_App",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/customer/add-inventory"
      }
    ]
  },
  {
    "type": "post",
    "url": "/customer/add-product-level",
    "title": "Add Product Level",
    "version": "0.1.0",
    "name": "postAddProductLevel",
    "group": "Customer_App",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Add product level and make product active with the help of barcode.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bar_code",
            "description": "<p>Product bar code (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pack_level",
            "description": "<p>Scanned product level (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage: ",
        "content": "{\n    \"bar_code\":\"prosinc-9538-0000-72-2,lifehinc-7034-0000-64-25\",\n    \"pack_level\":\"4\",\n    \"plant_id\":\"xxxx\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Level has been added.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>scanned product details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n  {\n    \"status\": true,\n    \"message\": \"Level has been added.\",\n    \"data\": [\n    {\n        \"id\": \"93\",\n        \"product_name\": \"ProsInc\",\n        \"attribute_list\": [\n            {\n                \"name\": \"Size\",\n                \"value\": \"6\"\n            },\n            {\n                \"name\": \"Colour\",\n                \"value\": \"Green\"\n            },\n            {\n                \"name\": \"Type\",\n                \"value\": \"tt1.1.15555\"\n            }\n        ],\n        \"industry_data\": [\n            {\n                \"industry\": \"Financials\"\n            }\n        ],\n        \"created_date\": \"2018-02-23 16:28:59\",\n        \"created_by\": \"217\",\n        \"status\": \"1\",\n        \"product_sku\": \"prosinc-9538\",\n        \"product_description\": \"Financial Product\",\n        \"product_images\": [\n            \"http://localhost/tracking/uploads/tmp/5a8ff413bb61e.png\",\n            \"http://localhost/tracking/uploads/tmp/5a8ff41454b9e.png\",\n            \"http://localhost/tracking/uploads/tmp/5a8ff4148840f.png\",\n            \"http://localhost/tracking/uploads/tmp/5a8ff414b993f.png\"\n        ],\n        \"product_video\": [\n            \"http://localhost/tracking/uploads/tmp/video_12_1519383597172.mp4\"\n        ],\n        \"product_audio\": [\n            \"http://localhost/tracking/uploads/tmp/sampleaudio_file-1519383638.mp3\"\n        ],\n        \"product_pdf\": [\n            \"http://localhost/tracking/uploads/tmp/brochure2-1519383631.pdf\",\n            \"http://localhost/tracking/uploads/tmp/brochure4-1519383636.pdf\",\n            \"http://localhost/tracking/uploads/tmp/brochure3-1519383636.pdf\",\n            \"http://localhost/tracking/uploads/tmp/brochure1-1519383637.pdf\"\n        ],\n        \"code_type\": \"qrcode\",\n        \"code_activation_type\": \"Pre-Activated\",\n        \"delivery_method\": \"3\",\n        \"code_key_type\": \"random\",\n        \"code_size\": \"M\",\n        \"other_industry\": \"\",\n        \"pbq_id\": \"28\",\n        \"active_status\": \"0\",\n        \"pack_level\": null,\n        \"barcode_qr_code_no\": \"prosinc-9538-0000-72-2\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Product",
            "description": "<p>has been already activated.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/customer.js",
    "groupTitle": "Customer_App",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/customer/add-product-level"
      }
    ]
  },
  {
    "type": "post",
    "url": "/customer/view-inventory?offset=:offset&limit=:limit",
    "title": "View Inventory",
    "version": "0.1.0",
    "name": "viewInventory",
    "group": "Customer_App",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>View Inventory.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of product inventory.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Inventory details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of product inventory\",\n    \"data\": [\n        {\n            \"inventory_id\": \"1\",\n            \"plant_id\": \"8998989\",\n            \"created_at\": \"2018-03-22 09:30:42\",\n            \"pack_level\": \"3\",\n            \"bar_code\": \"prosinc-9538-0000-72-2\",\n            \"active_status\": \"1\",\n            \"product_id\": \"93\",\n            \"product_name\": \"ProsInc\",\n            \"product_sku\": \"prosinc-9538\",\n            \"product_description\": \"Financial Product\",\n            \"attribute_list\": [\n                {\n                    \"name\": \"Size\",\n                    \"value\": \"6\"\n                },\n                {\n                    \"name\": \"Colour\",\n                    \"value\": \"Green\"\n                },\n                {\n                    \"name\": \"Type\",\n                    \"value\": \"tt1.1.15555\"\n                }\n            ],\n            \"industry_data\": [\n                {\n                    \"industry\": \"Financials\"\n                }\n            ],\n            \"product_images\": [\n                \"http://localhost/tracking/uploads/tmp/5a8ff413bb61e.png\",\n                \"http://localhost/tracking/uploads/tmp/5a8ff41454b9e.png\",\n                \"http://localhost/tracking/uploads/tmp/5a8ff4148840f.png\",\n                \"http://localhost/tracking/uploads/tmp/5a8ff414b993f.png\"\n            ],\n            \"product_video\": [\n                \"http://localhost/tracking/uploads/tmp/video_12_1519383597172.mp4\"\n            ],\n            \"product_audio\": [\n                \"http://localhost/tracking/uploads/tmp/sampleaudio_file-1519383638.mp3\"\n            ],\n            \"product_pdf\": [\n                \"http://localhost/tracking/uploads/tmp/brochure2-1519383631.pdf\",\n                \"http://localhost/tracking/uploads/tmp/brochure4-1519383636.pdf\",\n                \"http://localhost/tracking/uploads/tmp/brochure3-1519383636.pdf\",\n                \"http://localhost/tracking/uploads/tmp/brochure1-1519383637.pdf\"\n            ]\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/customer.js",
    "groupTitle": "Customer_App",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/customer/view-inventory?offset=:offset&limit=:limit"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/customer/view-product?offset=:offset&limit=:limit",
    "title": "View Products",
    "version": "0.1.0",
    "name": "viewProducts",
    "group": "Customer_App",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>View list of products.Use offset and limit to use pagination other it will retrieve 50 recrods at a time.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Level has been added.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>scanned product details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of products\",\n    \"data\": [\n        {\n            \"pack_level\": \"Test\",\n            \"bar_code\": \"lifehinc-7034-0000-64-1\",\n            \"active_status\": \"1\",\n            \"product_id\": \"91\",\n            \"product_name\": \"Lifehinc\",\n            \"product_sku\": \"lifehinc-7034\",\n            \"product_description\": \"\",\n            \"attribute_list\": [\n                {\n                    \"name\": \"Weight\",\n                    \"value\": \"100 GM\"\n                },\n                {\n                    \"name\": \"Type\",\n                    \"value\": \"tt1.1.15555\"\n                },\n                {\n                    \"name\": \"Heights\",\n                    \"value\": \"1 Feet\"\n                },\n                {\n                    \"name\": \"Heights\",\n                    \"value\": \"2 Feet\"\n                },\n                {\n                    \"name\": \"Heights\",\n                    \"value\": \"3 Feet\"\n                },\n                {\n                    \"name\": \"Heights\",\n                    \"value\": \"4 Feet\"\n                },\n                {\n                    \"name\": \"Weight\",\n                    \"value\": \"2 Kg\"\n                },\n                {\n                    \"name\": \"Weight\",\n                    \"value\": \"3 Kg\"\n                }\n            ],\n            \"industry_data\": [\n                {\n                    \"industry\": \"Financials\"\n                }\n            ],\n            \"product_images\": \"\",\n            \"product_video\": \"\",\n            \"product_audio\": \"\",\n            \"product_pdf\": \"\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Product",
            "description": "<p>has been already activated.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/customer.js",
    "groupTitle": "Customer_App",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/customer/view-product?offset=:offset&limit=:limit"
      }
    ]
  },
  {
    "type": "get",
    "url": "/product-details/:product_id",
    "title": "Warranty Status",
    "version": "0.1.0",
    "name": "GetProductDetails",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Get purchased products detail. content-type must be application/json in header request.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of purchased products.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of products.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of purchased products.\",\n    \"data\": {\n            \"bar_code\": \"lifehinc-7034-0000-64-2\",\n            \"purchased_id\": \"3\",\n            \"ordered_date\": \"2018-02-02 00:00:00\",\n            \"invoice\": \"#kdlskl3343\",\n            \"expiry_date\": \"2018-02-02\",\n            \"invoice_image\": \"http://localhost/tracking/uploads/invoice/profile210.jpg\",\n            \"product_id\": \"72\",\n            \"product_name\": \"FTLOverNight-Gold001\",\n            \"product_sku\": \"ftlovernight-gold001-2157\",\n            \"product_description\": \"\",\n            \"attribute_list\": [\n                {\n                    \"name\": \"Type\",\n                    \"value\": \"tt1.1.15555\"\n                }\n            ],\n            \"industry_data\": [\n                {\n                    \"industry\": \"Logistics\"\n                }\n            ],\n            \"product_images\": \"\",\n            \"product_video\": \"\",\n            \"product_audio\": \"\",\n            \"product_pdf\": \"\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/product-details/:product_id"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/purchased-product",
    "title": "My Product List",
    "version": "0.1.0",
    "name": "GetPurchasedProduct",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Get list of all purchased products detail. content-type must be application/json in header request.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of purchased products.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of products.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of purchased products.\",\n    \"data\": [\n        {\n            \"bar_code\": \"lifehinc-7034-0000-64-2\",\n            \"purchased_id\": \"3\",\n            \"purchased_date\": \"2018-02-02 00:00:00\",\n            \"invoice\": \"#kdlskl3343\",\n            \"expiry_date\": \"2018-02-02\",\n            \"invoice_image\": \"http://localhost/tracking/uploads/invoice/profile210.jpg\",\n            \"product_id\": \"72\",\n            \"product_name\": \"FTLOverNight-Gold001\",\n            \"product_sku\": \"ftlovernight-gold001-2157\",\n            \"product_description\": \"\",\n            \"attribute_list\": [\n                {\n                    \"name\": \"Type\",\n                    \"value\": \"tt1.1.15555\"\n                }\n            ],\n            \"industry_data\": [\n                {\n                    \"industry\": \"Logistics\"\n                }\n            ],\n            \"product_images\": \"\",\n            \"product_video\": \"\",\n            \"product_audio\": \"\",\n            \"product_pdf\": \"\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/purchased-product"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/redemption",
    "title": "View Redemption List",
    "version": "0.1.0",
    "name": "GetRedemption",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Get the list of redemption.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of redemption.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Redemption List.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of redemption\",\n    \"data\": [\n        {\n            \"aadhaar_number\": \"7876543456789876\",\n            \"alternate_mobile_no\": \"8765456\",\n            \"city\": \"New Delhi\",\n            \"state\": \"Delhi\",\n            \"street_address\": \"pocket c1, Mayurvihar phase 3\",\n            \"pin_code\": \"110096\",\n            \"points_redeemed\": \"20\",\n            \"coupon_number\": \"9889\",\n            \"coupon_type\": \"xyss\",\n            \"coupon_vendor\": \"tracking\",\n            \"courier_details\": \"\"\n        }\n    ]    \n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/redemption"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/view-scanned-product",
    "title": "View Scanned List",
    "version": "0.1.0",
    "name": "GetScannedProduct",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>View Scan product with barcode and relative product details of logged user.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Scanned product details.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Product details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Scanned product details.\",\n    \"data\": [\n        {\n            \"product_id\": \"72\",\n            \"bar_code\": \"prosinc-9538-0000-72-1\",\n            \"latitude\": \"33333.3333\",\n            \"longitude\": \"33.333333\",\n            \"created_at\": \"2018-02-25 20:51:45\",\n            \"product_name\": \"FTLOverNight-Gold001\",\n            \"product_sku\": \"ftlovernight-gold001-2157\",\n            \"product_description\": \"\",\n            \"attribute_list\": [\n                {\n                    \"name\": \"Type\",\n                    \"value\": \"tt1.1.15555\"\n                }\n            ],\n            \"industry_data\": [\n                {\n                    \"industry\": \"Logistics\"\n                }\n            ],\n            \"product_images\": \"\",\n            \"product_video\": \"\",\n            \"product_audio\": \"\",\n            \"product_pdf\": \"\"\n        },\n        {\n            \"product_id\": \"72\",\n            \"bar_code\": \"prosinc-9538-0000-72-1\",\n            \"latitude\": \"33333.3333\",\n            \"longitude\": \"33.333333\",\n            \"created_at\": \"2018-02-25 21:26:41\",\n            \"product_name\": \"FTLOverNight-Gold001\",\n            \"product_sku\": \"ftlovernight-gold001-2157\",\n            \"product_description\": \"\",\n            \"attribute_list\": [\n                {\n                    \"name\": \"Type\",\n                    \"value\": \"tt1.1.15555\"\n                }\n            ],\n            \"industry_data\": [\n                {\n                    \"industry\": \"Logistics\"\n                }\n            ],\n            \"product_images\": \"\",\n            \"product_video\": \"\",\n            \"product_audio\": \"\",\n            \"product_pdf\": \"\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/view-scanned-product"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/complaint",
    "title": "Complaint Log",
    "version": "0.1.0",
    "name": "PostComplaint",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Log your complain regarding purchased product. content-type must be application/json in header.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "bar_code",
            "description": "<p>product bar code. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Complaint type. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Describe the message want to convey (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"bar_code\":\"lifehinc-7034-0000-64-2\",\n    \"type\":\"complaint type\",\n    \"description\":\"Product is not working.\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your complain has been logged successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Input details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Your complain has been logged successfully.\",\n    \"data\": {\n        \"bar_code\": \"lifehinc-7034-0000-64-2\",\n        \"type\": \"product related\",\n        \"description\": \"one two\",\n        \"created_at\": \"2018-03-02 07:58:29\",\n        \"consumer_id\": \"9\",\n        \"complain_code\": \"085374\",\n        \"status\": \"pending\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/complaint"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/feedback-answer",
    "title": "Feedback Answer",
    "version": "0.1.0",
    "name": "PostFeedbackAnswer",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Save the consumer feedback answer.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>Purchased product id. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "question_id",
            "description": "<p>Purchased product id. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "product_qr_code",
            "description": "<p>product qr code. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "selected_answer",
            "description": "<p>answer selected by consumer. (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n\t\"product_id\":142,\n        \"product_qr_code\":\"8767yttrerr142\",\n\t\"question_id\":223,\n\t\"selected_answer\":\"answer3\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Feedback answer has been saved successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Input details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Feedback answer has been saved successfully.\",\n    \"data\": {\n        \"product_id\": 142,\n        \"question_id\": 2,\n        \"selected_answer\": \"answer3\",\n        \"user_id\": \"2\",\n        \"updated_date\": \"2018-04-27 10:56:39\",\n        \"created_date\": \"2018-04-27 10:56:39\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/feedback-answer"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/redemption/add",
    "title": "New Redemption",
    "version": "0.1.0",
    "name": "PostRedemptionAdd",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Save the consumer redemption.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "aadhaar_number",
            "description": "<p>Purchased product id. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "alternate_mobile_no",
            "description": "<p>Purchased product id. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "street_address",
            "description": "<p>product qr code. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "state",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pin_code",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "points_redeemed",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_number",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_type",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_vendor",
            "description": "<p>answer selected by consumer. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "courier_details",
            "description": "<p>answer selected by consumer. (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n\t\"aadhaar_number\":\"7876543456789876\",\n\t\"alternate_mobile_no\":\"8765456\",\n\t\"street_address\":\"pocket c1, Mayurvihar phase 3\",\n\t\"city\":\"New Delhi\",\n\t\"state\":\"Delhi\",\n\t\"pin_code\":\"110096\",\n\t\"points_redeemed\":\"20\",\n\t\"coupon_number\":\"9889\",\n\t\"coupon_type\":\"xyss\",\n\t\"coupon_vendor\":\"tracking\",\n\t\"courier_details\":\"\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Thank you for your redemption request, after validation, your request will be processed in next 7-10 Working days..</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Input details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Thank you for your redemption request, after validation, your request will be processed in next 7-10 Working days.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/redemption/add"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/register-product",
    "title": "My Product Registration",
    "version": "0.1.0",
    "name": "PostRegisterProduct",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Register the puchased product with following details. content-type must be application/json in header request and requested data must in form-data.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bar_code",
            "description": "<p>Barcode of product to scan. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "purchase_date",
            "description": "<p>Purchased date. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "invoice",
            "description": "<p>Ivoice of purchased product (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "invoice_image",
            "description": "<p>Ivoice image and must in format any one (png|gpeg|gpg|pdf) (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "expiry_date",
            "description": "<p>Product expiry date (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Product has been registered.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Input details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Product has been registered.\",\n    \"data\": {\n        \"bar_code\": \"prosinc-9538-0000-72-1\",\n        \"invoice\": \"#kdlskl3343\",\n        \"expiry_date\": \"2018-02-02\",\n        \"invoice_image\": \"http://localhost/tracking/uploads/invoice/profile28.jpg\",\n        \"ordered_date\": \"2018-02-02\",\n        \"consumer_id\": \"9\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/register-product"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/scan-product",
    "title": "Scan Product",
    "version": "0.1.0",
    "name": "PostScannedProduct",
    "group": "Product",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Scan product with barcode and retrieve the product details. content-type must be application/json in header request.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bar_code",
            "description": "<p>Barcode of product to scan. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude from where product scanned. (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude from where product scanned (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"bar_code\":\"prosinc-9538-0000-72-1\",\n    \"latitude\":\"33333.3333\",\n    \"longitude\":\"33.333333\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Scanned product details.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Product details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Scanned product details.\",\n    \"data\": {\n        \"id\": \"72\",\n        \"product_name\": \"FTLOverNight-Gold001\",\n        \"attribute_list\": [\n            {\n                \"name\": \"Type\",\n                \"value\": \"tt1.1.15555\"\n            }\n        ],\n        \"industry_data\": [\n            {\n                \"industry\": \"Logistics\"\n            }\n        ],\n        \"created_date\": \"2018-02-02 17:33:32\",\n        \"created_by\": \"199\",\n        \"status\": \"1\",\n        \"product_sku\": \"ftlovernight-gold001-2157\",\n        \"product_description\": \"\",\n        \"product_images\": \"\",\n        \"product_video\": \"\",\n        \"product_audio\": \"\",\n        \"product_pdf\": \"\",\n        \"code_type\": \"qrcode\",\n        \"code_activation_type\": \"Pre-Activated\",\n        \"delivery_method\": \"1\",\n        \"code_key_type\": \"serial\",\n        \"code_size\": \"S\",\n        \"other_industry\": \"\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/scan-product"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request like record not found or validation errors.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/consumer-loylty",
    "title": "Consumer loylties",
    "version": "0.1.0",
    "name": "getConsumerLoylty",
    "group": "Product",
    "permission": [
      {
        "name": "Private user"
      }
    ],
    "description": "<p>List of consumer earn loylties.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User gain loylties.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of loylties.\",\n    \"data\": [\n        {\n            \"id\": \"1\",\n            \"user_id\": \"2\",\n            \"points\": \"8\",\n            \"transaction_type\": \"Product Registration with Warranty\",\n            \"params\": {\n                \"product_id\": 21\n            },\n            \"date_expire\": \"2018-08-13 13:09:44\",\n            \"created_at\": \"2018-05-13 13:09:44\",\n            \"modified_at\": \"2018-05-13 13:09:44\"\n        },\n        {\n            \"id\": \"2\",\n            \"user_id\": \"2\",\n            \"points\": \"6\",\n            \"transaction_type\": \"Scan for Genuity and pdf Response\",\n            \"params\": {\n                \"product_id\": 142,\n                \"question_id\": \"2\"\n            },\n            \"date_expire\": \"2018-08-13 13:13:36\",\n            \"created_at\": \"2018-05-13 13:13:36\",\n            \"modified_at\": \"2018-05-13 13:13:36\"\n        },\n        {\n            \"id\": \"3\",\n            \"user_id\": \"2\",\n            \"points\": \"8\",\n            \"transaction_type\": \"Product Registration with Warranty\",\n            \"params\": {\n                \"product_id\": 22\n            },\n            \"date_expire\": \"2018-08-14 08:57:18\",\n            \"created_at\": \"2018-05-14 08:57:18\",\n            \"modified_at\": \"2018-05-14 08:57:18\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/consumer-loylty"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/feedback-question/(:product_id)",
    "title": "Feedback Question",
    "version": "0.1.0",
    "name": "getFeedbackQuestion",
    "group": "Product",
    "permission": [
      {
        "name": "Private user"
      }
    ],
    "description": "<p>List of feedback question related to product.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>existing product id (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of questions for feedback.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of questions for feedback.\",\n    \"data\": [\n        {\n            \"question_id\": \"5\",\n            \"question\": \"Q1\",\n            \"question_type\": \"\",\n            \"answer1\": \"opt1\",\n            \"answer2\": \"opt2\",\n            \"answer3\": \"opt3\",\n            \"answer4\": \"opt4\",\n            \"correct_answer\": \"2\"\n        }\n    ]    \n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/scanned_product.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/feedback-question/(:product_id)"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/loylties",
    "title": "List of loylties",
    "version": "0.1.0",
    "name": "getLoylties",
    "group": "Product",
    "permission": [
      {
        "name": "Private user"
      }
    ],
    "description": "<p>List of loylties.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token must be set in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of loylties.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"List of loylties.\",\n    \"data\": [\n        {\n            \"id\": \"1\",\n            \"transaction_type\": \"User Registration\",\n            \"points\": \"100\",\n            \"customer\": null,\n            \"product\": null,\n            \"status\": \"1\",\n            \"created_at\": \"2018-05-12 00:00:00\",\n            \"modified_at\": \"2018-05-12 00:00:00\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "Product",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/loylties"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/forgot-password/(:mobile_no|:email)",
    "title": "Forgot Password",
    "version": "0.1.0",
    "name": "GetForgot_password",
    "group": "User",
    "permission": [
      {
        "name": "Public user"
      }
    ],
    "description": "<p>To change the forgotten password.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "mobile_no",
            "description": "<p>|email Any one registered Mobile no or email (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>A new password has been sent to your registered mobile no.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"A new password has been sent to your registered mobile no.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/forgot-password/(:mobile_no|:email)"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/logout",
    "title": "Logout",
    "version": "0.1.0",
    "name": "GetLogout",
    "group": "User",
    "permission": [
      {
        "name": "Registered User only"
      }
    ],
    "description": "<p>Get logout to the logged in user.Token must be in header.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Logout successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Logout successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/logout"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/resendotp/(:mobile_no)",
    "title": "Resendotp",
    "version": "0.1.0",
    "name": "GetResendotp",
    "group": "User",
    "permission": [
      {
        "name": "Public user"
      }
    ],
    "description": "<p>Resend One time password.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "mobile_no",
            "description": "<p>Registered Mobile no (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>OTP has been sent successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"OTP has been sent successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/resendotp/(:mobile_no)"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/user/view",
    "title": "View Profile",
    "version": "0.1.0",
    "name": "GetView",
    "group": "User",
    "permission": [
      {
        "name": "Logged in user"
      }
    ],
    "description": "<p>To view profile details.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be in header.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your account details..</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Your account details.\",\n    \"data\": {\n        \"id\": \"1\",\n        \"user_name\": \"devtest\",\n        \"email\": \"devtest@gmail.com\",\n        \"password\": \"999ca51334ef2896b0c10707a278cb29\",\n        \"mobile_no\": \"9716322087\",\n        \"gender\": \"male\",\n        \"dob\": \"1988-02-02\",\n        \"ip\": \"::1\",\n        \"is_verified\": \"1\",\n        \"verification_code\": \"997453\",\n        \"status\": \"inactive\",\n        \"terms_conditions\": \"0\",\n        \"created_at\": \"2018-02-16 15:42:10\",\n        \"modified_at\": \"2018-02-19 22:19:14\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/user/view"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/change-password",
    "title": "Change password",
    "version": "0.1.0",
    "name": "PostChange_password",
    "group": "User",
    "permission": [
      {
        "name": "Only logged in user"
      }
    ],
    "description": "<p>Change the existing password.Request must be in json.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>Existing password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>new password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<p>repeat the new password (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>New password has been changed successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"New password has been changed successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/change-password"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/user/edit",
    "title": "Edit profile",
    "version": "0.1.0",
    "name": "PostEdit",
    "group": "User",
    "permission": [
      {
        "name": "Only logged in user"
      }
    ],
    "description": "<p>update profile details.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be in header.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>user name (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>must be any one male|female(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dob",
            "description": "<p>date of birth in format YYYY-mm-dd (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your account has been updated.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Your account has been updated.\",\n    \"data\": {\n        \"user_name\": \"devtest\",\n        \"gender\": \"male\",\n        \"dob\": \"1988-2-2\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/user/edit"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/login",
    "title": "Login",
    "version": "0.1.0",
    "name": "PostLogin",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>User login with user name and its password.User get logged in by using username and password including device_id.content-type must be application/json in header request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>Either registered email or mobile no (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>secret password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<p>Device personal id (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage: ",
        "content": "{\n   \"username\": \"devtest@gmail.com/9887876767\",\n   \"password\": \"XXXXXXXXX\",\n   \"device_id\":\"DATEOSDEVICEIP\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Login done successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of user details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Login successfully.\",\n    \"data\": {\n        \"user_name\": \"dev test\",\n        \"email\": \"devtest@gmail.com\",\n        \"gender\": \"male\",\n        \"dob\": \"2000-02-02\",\n        \"mobile_no\": \"9343233787\",\n        \"avatar_url\": \"http://domain.com/uploads/consumer/abc.png\",\n        \"id\": \"1\",\n        \"token\": \"ebd65aa7817b650ad78b2b68f989c742\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Sign",
            "description": "<p>in credentials ain't right, try again buddy.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/login"
      }
    ]
  },
  {
    "type": "post",
    "url": "/resendmail",
    "title": "Resend Mail",
    "version": "0.1.0",
    "name": "PostResendmail",
    "group": "User",
    "permission": [
      {
        "name": "Public user"
      }
    ],
    "description": "<p>Resend mail to verify email.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Registered Email id (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Mail has been sent successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Mail has been sent successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/resendmail"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/register",
    "title": "Register User",
    "version": "0.1.0",
    "name": "PostUser",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Create a new account. Register new user with below following parameters.content-type must be application/json in header request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>Username size between 4-50 charecters (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of user must be unique (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<p>Date of birth must in in format YYYY-DD-MM (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of user like any one (male, femal) (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "mobile_no",
            "description": "<p>Mobile no of user and accept only 10 digits only and must be unique(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Bool",
            "optional": false,
            "field": "terms_conditions",
            "description": "<p>Terms and conditions  (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"user_name\":\"devtest\",\n    \"email\":\"devtest@gmail.com\",\n    \"mobile_no\":\"9343233787\",\n    \"gender\":\"male\",\n    \"dob\":\"2000-2-2\",\n    \"terms_conditions\":\"0\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Registration done successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of user details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n {\n    \"status\": true,\n    \"message\": \"Your account has been created.\",\n    \"data\": {\n        \"user_name\": \"dev test\",\n        \"email\": \"dev.test@gmail.com\",\n        \"mobile_no\": \"9343233781\",\n        \"gender\": \"male\",\n        \"dob\": \"2000-2-2\",\n        \"terms_conditions\": \"1\"\n        \"created_at\": \"2018-02-11 17:47:39\",\n        \"modified_at\": \"2018-02-11 17:47:39\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/register"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/verifyotp",
    "title": "Verifyotp",
    "version": "0.1.0",
    "name": "PostVerifyotp",
    "group": "User",
    "permission": [
      {
        "name": "Public user"
      }
    ],
    "description": "<p>Verify One time password. content-type must be application/json in header request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "mobile_no",
            "description": "<p>Registered Mobile no (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "otp",
            "description": "<p>One time password sent on mobile (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage: ",
        "content": "{\n    \"mobile_no\":\"7678665537\",\n    \"otp\":\"819124\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your account has been successfully verified.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "HTTP/1.1 200 OK\n{\n    \"status\": true,\n    \"message\": \"Your account has been successfully verified.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/verifyotp"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/upload-avatar",
    "title": "Upload Profile Image",
    "version": "0.1.0",
    "name": "postUploadAvatar",
    "group": "User",
    "permission": [
      {
        "name": "Private user"
      }
    ],
    "description": "<p>Upload profile image.Image mime type must be image/png,image/gif and image/jpg and size below 4MB.Data must be sent in form-data format on HTTP.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<ul> <li>Token must be in header.</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "avatar",
            "description": "<ul> <li>Profile Image object (Required).</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Image has been uploaded successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n    {\n    \"status\": true,\n    \"message\": \"Image has been uploaded successfully.\",\n    \"data\": {\n        \"avatar_url\": \"http://domain.com/uploads/consumer/profile11.jpg\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "doc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "https://innovigents.com/api/upload-avatar"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "status",
            "description": "<p>false.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "message",
            "description": "<p>api error as per request.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "errors",
            "description": "<p>validation errors.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (example):",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"status\":false,\n   \"message\": \"Bad request\"\n}",
          "type": "json"
        }
      ]
    }
  }
] });
