This is a supporting repo for the Nexmo blog post 
[stream audio in to a call with PHP](#). See the blog post for a step by step 
walkthrough and explanation of the code

### Quick Start

* Install dependencies - `composer install`
* Run the application - `php -t . -S localhost:8000`
* Expose your application to the internet - `ngrok serve http 8000`
* Update your `answer_url` and `event_url` in your Nexmo application
* Call your Nexmo Number to hear the welcome message
* Make a reques to `/trigger/<ID>/1` to play audio in to an active call


