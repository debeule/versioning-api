# DWH data => db_raw
save the external data in a local db.

# db_raw => anti-corruption-layer
restructure & clean raw data into usable data
see [docs/plans/acl.md]

# anti-corruption-layer => save data to db_new
when anti corruption layer is done save data to new db

# db_new => api endpoints
build the api

