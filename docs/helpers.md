# Helpers

## concatenate()

Concatenate joins strings passed as arguments. 

_Example Usage_
`concatenate('Day',105);`

Results: **Day105**

## concatenate_with_separator()

Concatenate joins strings passed as arguments, separated with what you pass as the first argument. 

_Example Usage_
`concatenate_with_separator(':', 'Day',105);`

Results: **Day:105**

## getDbPropertyId

This gets a property from the database. This is useful when you have, for example, a foreign keyed table and you
want to get a the id of a particular row. 

For example, we might have a logs table which stores a log about something and on that table there is a type_id column. 
So you may want to do a query which searches for particular log type. Rather than hard coding an ID `getDbPropertyId`
will return you the id you require. 

_Example Usage_
_In this example we're looking for type 'printed', on the table log_types_

`getDbPropertyId('Printed', 'log_types');`

    This would be the same as running SELECT id FROM log_types WHERE name = 'Printed'

Returns (id of row)

You can also specify the name of the column you wish to query should it not be 'name'. Name is the default. 

For example

`getDbPropertyId('Printed', 'log_types', 'typeName');`

    This would be the same as running SELECT id FROM log_types WHERE typeName = 'Printed'
    
## ddd

This is an extension of the die and dump function in Laravel. ddd will add the File and Line number 
of where the die and dump is and also the debugging stack. 

_Example Usage_

ddd($someVariable);
