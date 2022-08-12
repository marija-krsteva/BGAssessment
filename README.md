# Rizk PHP assessment

## Overview
You are handed a project which uses SQL, Redis and PHP.
The users are stored in table "user" in SQL and there is a basic PHP class User.

The users can be given items, which can be of 4 different types:

1. 5 free spins
2. 10 free spins
3. 5 euros
4. 1 Raffle ticket

In the future there will be more item types, so be prepared for this in your implementation.

1. Design the SQL for saving items in general
2. Design API to add and remove items from users
3. Implement function exchange() which exchanges 5 free spins to 5 euros, 2*5 Freespins to 10e etc.
4. How would you utilize Redis for caching?
   **- Redis could be used for caching all resources (wheels, users, rewards, number of items a user has etc), so the retrieval of these resources is faster.
   Every time an update or create happens for one of the resources, we can update the key => value pairs. Also, it would be really usefull for
   resources that don't change that often but are needed constantly ( item types, item exchange rates etc).**
