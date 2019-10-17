**Show User**
----
  Returns json data about a single position by ID.

* **URL**

  /v1/positions/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
    {
        "id":1,
        "title":"Senior PHP Developer",
        "seniority_level":"Senior",
        "country":"DE",
        "city":"Berlin",
        "salary":747500,
        "currency":"SVU",
        "skills":["PHP","Symfony","REST","Unit-testing","Behat","SOLID","Docker","AWS"],
        "company":{
            "size":"100-500",
            "domain":"Automotive"
        }
    }
    ```
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** 
    ```json
        {
            "description":"Position with ID = :id not found"
        }
    ```

[Back to list](README.md)