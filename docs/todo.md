# Some improvements I would like to do

- _Authorization_. Now it's a fully open API without any authentification. With some authorization and authentification (JWT, for example) I can hide/show some fields for users with different access level
- _MySQL/PostreSQL_. It's easy to replace the source of positions in this version of the application, but some methods are redundant (like sorting or filtering rows because MySQL/PostgreSQL can do it much better). It brings complexity (O(1) -> ~O(n)) and increases response time.
- _Custom Error Handler_. If you go to the non-existent page or some errors occurs on the server, you'll see the default Symfony error page. It's not cool.
- _Better Code Structure_. Base folder and class structure are ok for a small application, but for medium and big application, I prefer domain structure.
- _Monitoring/Logging_. For now, it's not a production-ready application and one of the reasons is monitoring and logging (It's mandatory if you want to prevent or find out when something goes wrong).
- _CI/CD_. I want to be confident when ыomeone push new commits to git-server or create merge request to master branch. I used to configure 'lint' and 'test' pipelines in Gitlab-CI. And one more advantage is one-click deploy.

[Back](../README.md)