<?php

/**
 * A quick & dirty print desk implementation for the print service.
 *
 * @author Laju Morrison <morrelinko@gmail.com>
 */

require('./vendor/autoload.php');

define('API_HOST', 'http://127.0.0.1:4000');
define('ACCESS_TOKEN', 'testclient:testsecret');
define('CACHE_DIR', __DIR__ . '/cache');

require_once 'view.header.php';

if (isset($_GET['job_id'])) {
    try {
        $jobId = filter_var($_GET['job_id'], FILTER_SANITIZE_STRING);
        $printJob = GuzzleHttp\get(
            sprintf('%s/print-jobs/%s', API_HOST, $jobId),
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . ACCESS_TOKEN
                ]
            ]
        )->json()['data'];

        if (isset($_GET['action']) && ($action = $_GET['action'])) {
            if ($action == 'open_document') {
                $document = $printJob['documents'][$_GET['$index']];
                $hash = md5($document['id'] . $document['job_id']);
                $cache = CACHE_DIR . '/' . $hash . '.' . pathinfo($document['file_name'], PATHINFO_EXTENSION);
                if (!file_exists($cache)) {
                    file_put_contents($cache, file_get_contents(sprintf('%s/%s', API_HOST, $document['url'])));
                }

                // Force Download
            }
        }

        // VIEW
        require_once 'view.job.php';
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        $response = $e->getResponse()->json();
        print_r($response['error']['message']);
    }

} else {
    // VIEW
    require_once 'view.index.php';
}

require_once 'view.footer.php';
