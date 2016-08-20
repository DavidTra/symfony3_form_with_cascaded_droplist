# symfony3 form with cascaded dropdown list
symfony3 project - form with cascaded dropdown list

This is an example of how to create a dynamically modified form using FormEvents in symfony3

In this example we have 3 entities (Province, City, Account) which are linked as following : "P" <1 - n> "C" <1-n "A"
Unlike the example provided in the official documentation, here there is no relationship between Province and Account entites which means you can cascaded multiple choices dropdown list

Some key points on which you shoudl pay attention are:
-Province is added as a non mapped field to the form
-The second event listener is add to the province field not to the form. This will give the possibility to get the Province submitted value and not the empty value form the new entity used for the form
-City is added in the POST_SUBMIT with a query buider. This give the possibility to get the correct value to city field.
-function (EntityRepository $er) use ($province) : EntityRepository is used not EntityManager and the parater is pass to the querybuilder with "use ($province)"



