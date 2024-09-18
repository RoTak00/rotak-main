<?php

class AccountAuthModel extends BaseModel
{

    function onLoad()
    {
        $this->RemoveExpiredAuthTokens("1 HOUR");
    }
    function InsertAuthToken()
    {
        $token = uniqid("auth_");

        $sqlq = "INSERT INTO auth_session(token) VALUES ('" . $token . "')";

        $result = $this->registry['db']->query($sqlq);

        return $token;
    }

    // selects the authentication token from the database
// or returns null if none are found
// null allows to be used with coercion (??) operator
    function GetAuthToken($token)
    {
        $sqlq = "SELECT valid FROM auth_session WHERE token = '" . $token . "'";

        $result = $this->registry['db']->query($sqlq);

        if (!($result->num_rows > 0)) {
            return null;
        }

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
        }

        $result = ($result['valid'] == 1 ? $token : null);
    }

    // Validate an authentication token array (defined as "token": token, "valid": isvalid)
// Can also be null if the token was not found at all
// If valid, authenticate user
// If not valid, alert user that session has expired
// If null, an error has occured or malicious use exists
    function ValidateAuthToken($authToken, $unsetSessionTokenOnInvalid = true)
    {

        // probably malicious use, the tokens added to the session should always be existent in the database, even if invalid
        if (is_null($authToken)) {
            session_unset();
            die();
        }

        // authentication token does exist but is invalid because too much time has passed
        // redirect the user to the login page and ask to reconnect
        if ($authToken['valid'] == 0) {
            if ($unsetSessionTokenOnInvalid)
                unset($_SESSION['auth_token']);

            // transform the previous query string to allow the browser to know where to redirect going forward
            // it needs to be transformed in order to fit into one single value
            // so / is turned to custom &sl;
            header("location: login");
            die();
        }

        // authentication token exists and is valid, login success
        // reset last validation date of auth token 
        if ($authToken['valid'] == 1) {
            $this->ResetValidationToken($authToken['token']);
            return true;
        }


    }

    // Reset the last_validated date for the authentication token
// This means that it will not be invalidated for the next hour
    function ResetValidationToken($token)
    {
        $sqlq = "UPDATE auth_session SET last_validated = NOW() WHERE token = '" . $token . "'";

        $result = $this->registry['db']->query($sqlq);

        return true;
    }

    // checks for auth tokens older than interval
    // and marks them as invalid
    function RemoveExpiredAuthTokens($interval)
    {
        $sqlq = "UPDATE auth_session SET valid = 0 WHERE last_validated < NOW() - INTERVAL " . $interval;

        $result = $this->registry['db']->query($sqlq);
        return true;
    }

    function RemoveAuthToken($token)
    {
        $sqlq = "UPDATE auth_session SET valid = 0 WHERE token = '" . $token . "'";

        $result = $this->registry['db']->query($sqlq);

        return true;
    }


}