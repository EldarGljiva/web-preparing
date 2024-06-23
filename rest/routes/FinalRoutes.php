<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('GET /final/connection-check', function () {
    /** TODO
     * This endpoint prints the message from constructor within MidtermDao class
     * Goal is to check whether connection is successfully established or not
     * This endpoint does not have to return output in JSON format
     */
    $object = new FinalDao();
});

Flight::route('POST /final/login', function () {
    /** TODO
     * This endpoint is used to login user to system
     * you can use email: demo.user@gmail.com and password: 123 to login
     * Output should be array containing success message and JWT for this user
     * Sample output is given in figure 7
     * This endpoint should return output in JSON format
     */
    $data = Flight::request()->data->getData();
    $user = Flight::finalService()->login($data['email']);
    if ($user && $data['email'] == $user['email'] && $data['password'] == $user['password']) {
        $secretKey = Config::JWT_SECRET();
        $payload = [
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24),
        ];
        $jwt = JWT::encode($payload, $secretKey, 'HS256');
        Flight::json(['message' => 'User Logged in Succesfully', 'token' => $jwt]);
    } else {
        Flight::json(['error' => 'User not found in database or email is incorrect']);
    }
});

Flight::route('POST /final/register', function () {
    $data = Flight::request()->data->getData();
    if ($data) {
        Flight::json(['message' => "User Registered Succesfully", 'id of the user' => Flight::finalService()->register($data)]);
    } else {
        Flight::json(['error' => 'Invalid data. Please try again.']);
    }
});


Flight::route('POST /final/investor', function () {
    /** TODO
     * This endpoint is used to add new record to investors and cap-table database tables.
     * Investor contains: first_name, last_name, email and company
     * Cap table fields are share_class_id, share_class_category_id, investor_id and diluted_shares
     * RULE 1: Sum of diluted shares of all investors within given class cannot be higher than authorized assets field
     * for share class given in share_classes table
     * Example: If share_class_id = 1, sum of diluted_shares = 310 and authorized_assets for this share_class = 500
     * It means that investor added to cap table with share_class_id = 1 cannot have more than 190 diluted_shares
     * RULE 2: Email address has to be unique, meaning that two investors cannot have same email address
     * If added successfully output should be the message that investor has been created successfully
     * If error detected appropriate error message should be given as output
     * This endpoint should return output in JSON format
     * Sample output is given in figure 2 (message should be updated according to the result)
     */
});


Flight::route('GET /final/share_classes', function () {
    /** TODO
     * This endpoint is used to list all share classes from share_classes table
     * This endpoint should return output in JSON format
     */
    Flight::json(Flight::finalService()->share_classes());
});

Flight::route('GET /final/share_class_categories', function () {
    /** TODO
     * This endpoint is used to list all share class categories from share_class_categories table
     * This endpoint should return output in JSON format
     */
    Flight::json(Flight::finalService()->share_class_categories());
});
