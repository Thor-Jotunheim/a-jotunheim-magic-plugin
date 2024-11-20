/*
<?php
if (!defined('ABSPATH')) exit; // Prevent direct access

// Function to generate JWT token
function generate_jwt_token($user_id) {
    $issuedAt = time();
    $expiration = $issuedAt + DAY_IN_SECONDS; // Token valid for 1 day

    if (!defined('JWT_AUTH_SECRET_KEY')) {
        return new WP_Error('jwt_auth_bad_config', __('JWT is not properly configured in wp-config.php'), array('status' => 403));
    }

    $token = array(
        'iss' => get_bloginfo('url'), // Issuer
        'iat' => $issuedAt,           // Issued at time
        'exp' => $expiration,         // Expiration time
        'data' => array(
            'user' => array(
                'id' => $user_id
            )
        )
    );

    return JWT::encode($token, JWT_AUTH_SECRET_KEY); // Encode the token
}

// Function to check user role and generate a token if authorized
function generate_token_for_authorized_roles($user_id) {
    $user = get_userdata($user_id);

    // Only generate a token if the user has the Administrator or Editor role
    if (!$user || !in_array($user->roles[0], ['administrator', 'editor'])) {
        return null; // User not authorized, no token generated
    }

    return generate_jwt_token($user_id); // Generate the JWT token
}
*/