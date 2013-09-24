nitlab-administrator-front-end
==============================

Nitlab's front end for the administrator.

This is a project for managing the NITOS testbed's resources.
It is built on top of the NITOS API(https://github.com/NitLab/Nitos_api)

Currently, the administrator can manage the following resources : 

*Users (apparently these are the joomla users of NITOS web interface)
*Slices
*Resources – both nodes and channels
*Reservation information for the nodes and the channels

Known Bugs : 

1) Click add, then add a resource. After that, all buttons do not work when you click on them. You need to refresh the page. This has to with javasript.
2) Editing node type on nodes tab does not work(the problem is in the API)
3) Editing node name on nodes tab does not work(the problem is in the API)
4) When you create a new resource and the table is empty, then you have to refresh the page in order to see the new resources. The problem happens because you copy an existing row of the table instead of creating a new one in create.js
5) If you delete a channel/node/slice for which there is a reservation, then the reservation tab does not work. (This is a problem of the API)


Possible Improvements : 

1) We could use caching mechanisms of codeigniter( http://ellislab.com/codeigniter/user-guide/general/caching.html) to reduce response time for each tab. 
2) The slices tab takes some time to load. Probably, it is caused by increased load time of js files. We could profile execution by using the browser's profiler and optimize the relevant parts.
