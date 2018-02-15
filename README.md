# Api Sample Library

Sample of RestApi
# Library Api

--------------------------------------------------------------------------------
## Authentication

The client ID and secret are the key and secret for authentication.

if(empty(session_id();)) session_start();

require_once 'vendor/autoload.php';

$lib = new \Library\Lib(array(<br>
	'client_id'     => 'XXX',<br>
	'client_secret' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',<br>
	'redirectUri'  => 'http://example.com/',<br>
));

--------------------------------------------------------------------------------
## Making REST Requests

The PHP SDK is setup to allow easy access to REST endpoints. In general, a single result is returned as a Class representing that object, and multiple objects are returned as an Sample Collection, which is simply a wrapper around an array of results making them easier to manage.<br>

The standard REST operations are mapped to a series of simple functions. We'll use the Profile service for our examples, but the operations below work on all documented Sample REST services.<br>

To retrieve all profiles:<br>
$profile = $lib->profiles()->all();
<br>
To retrieve profiles with filter:<br>
$profiles = $lib->profiles()->filter('country_id', '=', 42)->all();
<br>
To retrieve profiles with include:<br>
$profiles = $lib->profiles()->include('customers')->all();
<br>
To retrieve a single profile:<br>
$profile = $lib->profiles()->find($profileId);
<br>
To query only completed profile:<br>
$profile = $lib->profiles()->where('email', 'example@gmail.com')->get();
<br>
$attributes = [<br>
    'name' => 'profile name',<br>
    'email' => 'example@gmail.com'<br>
];
<br>
To create a profile:<br>
$profile = $lib->profiles()->create($attributes);

To update a profile:<br>
$profile = $lib->profiles()->update($attributes, $profileId);

To upload a file<br>
$profile = $lib->profiles()->upload([<br>
   'id' => $profileId,<br>
   'file' => $filePath<br>
]);<br>

And finally, to delete the profile:<br>
$lib->profiles()->delete($id);
