<?php

// AUTHENTICATION TOKENS

// currently just generates an auth token but does not support multiple accounts
// returns the auth token
function InsertAuthToken()
{
    $sqlq = "INSERT INTO auth_session(token) VALUES (?)";
    global $conn;

    if(!($stmt = $conn->prepare($sqlq)))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    $token = uniqid("auth_");
    $stmt -> bind_param("s", $token);

    if(!($stmt -> execute()))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    return $token;
}

// selects the authentication token from the database
// or returns null if none are found
// null allows to be used with coercion (??) operator
function GetAuthToken($token)
{
    $sqlq = "SELECT valid FROM auth_session WHERE token = ?";
    global $conn;

    if(!($stmt = $conn->prepare($sqlq)))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    $stmt -> bind_param("s", $token);

    if(!($stmt -> execute()))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    $valid = "";
    $stmt->bind_result($valid);

    $result = [];
    if($stmt->fetch())
    {
        $result = [
            "token" => $token,
            "valid" => $valid,
        ];
    }

    $stmt->close();

    return (empty($result) ? null : $result);
}

// Validate an authentication token array (defined as "token": token, "valid": isvalid)
// Can also be null if the token was not found at all
// If valid, authenticate user
// If not valid, alert user that session has expired
// If null, an error has occured or malicious use exists
function ValidateAuthToken($authToken, $unsetSessionTokenOnInvalid = true)
{

    // probably malicious use, the tokens added to the session should always be existent in the database, even if invalid
    if(is_null($authToken))
    {
        session_unset();
        AddAlert("Token-ul de autentificare e inexistent. Nu te mai juca cu variabilele de sesiune, nesimțitule!", "danger");
        header("location: ./error/auth_token_inexistent");
        die();
    }

    // authentication token does exist but is invalid because too much time has passed
    // redirect the user to the login page and ask to reconnect
    if($authToken['valid'] == 0)
    {
        if($unsetSessionTokenOnInvalid)
            unset($_SESSION['auth_token']);

        AddAlert("Sesiunea a expirat. Te rugăm să te reconectezi!", "warning");

        // transform the previous query string to allow the browser to know where to redirect going forward
        // it needs to be transformed in order to fit into one single value
        // so / is turned to custom &sl;
        $previousQueryString = str_replace("/", "&sl;", $_SERVER['QUERY_STRING']);
        header("location: /".($GLOBALS['useFolderNamePrefix']??"")."error/auth_token_expired/previous/".$previousQueryString);
        die();
    }

    // authentication token exists and is valid, login success
    // reset last validation date of auth token 
    if($authToken['valid'] == 1)
    {
        ResetValidationToken($authToken['token']);
        return true;
    }


}

// Reset the last_validated date for the authentication token
// This means that it will not be invalidated for the next hour
function ResetValidationToken($token)
{
    $sqlq = "UPDATE auth_session SET last_validated = ? WHERE token = ?";
    global $conn;
    global $current_date;

    if(!($stmt = $conn->prepare($sqlq)))
    {
        return false;
    }

    
    $stmt -> bind_param("ss", $current_date, $token);

    if(!($stmt -> execute()))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    return true;
}

// checks for auth tokens older than interval
// and marks them as invalid
function RemoveExpiredAuthTokens($interval)
{
    $sqlq = "UPDATE auth_session SET valid = 0 WHERE last_validated < NOW() - INTERVAL ".$interval;
    global $conn;

    if(!($stmt = $conn->prepare($sqlq)))
    {
        return false;
    }


    if(!($stmt -> execute()))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    return true;
}

function RemoveAuthToken($token)
{
    $sqlq = "UPDATE auth_session SET valid = 0 WHERE token = ?";
    global $conn;

    if(!($stmt = $conn->prepare($sqlq)))
    {
        return false;
    }

    $stmt -> bind_param("s", $token);

    if(!($stmt -> execute()))
    {
        AddAlert($conn->error, "danger");
        return false;
    }

    return true;
}

?>