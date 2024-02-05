# anti corruption layer requirements:
- cleanup
- safety validation
- restructure data

## cleanup
### strings
- trim
- fix casing
- convert numeric characters in strings to apropriate types

### primary keys
- reindex all primary keys
    reason:
    - negative indexes
    - duplicate records (with references to both)

## safety validation
- check for presence of scripts
- 

## restructure data 
- rebuild table dependencies
- 