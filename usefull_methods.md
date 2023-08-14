# ARRAY TO OBJECT FOREACH STDCLASS
	 foreach ($userLastMessage as $key => $value) {
			 	$this->stdclass->$key = $value;
					}

	(object) $withStatus = (object)$withStatus->toArray();


# Eloquent methods findOrFail VS find
$this->botUserModel->find($id);

		if (is_null($user_found)) {
			echo ('USER NOT FOUND  error message');
			return abort(404); }

# How to define an empty object in PHP
# https://stackoverflow.com/questions/1434368/how-to-define-an-empty-object-in-php
