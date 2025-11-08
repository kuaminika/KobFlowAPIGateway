<?php
/**
 * GoogleTokenVerifier
 * Lightweight helper to verify and decode a Google ID token without Composer.
 *
 * Usage:
 *   $verifier = new GoogleTokenVerifier('YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com');
 *   $result = $verifier->verify($idToken);
 *   if ($result['valid']) {
 *       $user = $result['payload'];
 *   } else {
 *       error_log($result['error']);
 *   }
 */
class GoogleTokenVerifier
{
    private string $clientId;
    private string $endpoint = 'https://oauth2.googleapis.com/tokeninfo';

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Verify a Google ID token using Google's tokeninfo endpoint.
     *
     * @param string $idToken  The ID token (JWT) from the client
     * @return array  [
     *     'valid' => bool,
     *     'payload' => array (if valid),
     *     'error' => string (if invalid)
     * ]
     */
    public function verify(string $idToken): array
    {
        if (empty($idToken)) {
            return ['valid' => false, 'error' => 'Missing ID token'];
        }

        $url = $this->endpoint . '?id_token=' . urlencode($idToken);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            return [
                'valid' => false,
                'error' => "Google verification failed: HTTP $httpCode $curlError",
            ];
        }

        $payload = json_decode($response, true);
        if (!is_array($payload)) {
            return ['valid' => false, 'error' => 'Invalid JSON response from Google'];
        }

        // Check audience
        if (($payload['aud'] ?? '') !== $this->clientId) {
            return ['valid' => false, 'error' => 'Token audience mismatch'];
        }

        // Optional: check expiration (exp)
        if (isset($payload['exp']) && time() > $payload['exp']) {
            return ['valid' => false, 'error' => 'Token expired'];
        }

        return ['valid' => true, 'payload' => $payload];
    }
}
