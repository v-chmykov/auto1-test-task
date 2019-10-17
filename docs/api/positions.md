**Show User**
----
  Returns JSON data about all positions.
  Filter by country or city may be used. WHen filter applied you can sort the result by seniority level or salary (ascending only).

* **URL**

  /v1/positions

  /v1/positions?country=DE

  /v1/positions?city=Berlin

  /v1/positions?city=Berlin&sort=salary

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

   **Optional:**
 
   `country=[string]` - country code (Example: `DE`)

   `city=[string]` - city name (Example: `Berlin`)

   `sort=[string]` - position field to sort by (Only `seniority_level` and `salary` acceptable). Appliable only with country/city filter.

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

  * **Code:** 404 NOT FOUND <br />
    **Content:** 
    ```json
        {"description":"Positions with the field \"filed\" and the value \":value\" not found"}
    ```


[Back to list](README.md)