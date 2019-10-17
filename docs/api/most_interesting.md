**Show User**
----
  Returns json data about the most interesting positions by skills.

* **URL**

  /v1/positions/most_interesting?skills=

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `skills=[string]` - array of skills (comma separated)

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
        [
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
            },
            ...
        ]
    ```
 
* **Error Response:**

  * **Code:** 400 BAD REQUEST <br />
    **Content:** 
    ```json
        { 
            "description":"No skills provided"
        }
    ```

  OR

  * **Code:** 404 NOT FOUND <br />
    ```json
        { 
            "description":"Positions with skills \":skills\" not found"
        }
    ```

[Back to list](README.md)