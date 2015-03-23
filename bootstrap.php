<?php


// API

$this->module("mailqueue")->extend([

    // what tablename to use in the datastore
    "tablename"      => "mailqueue",

    // constants
    "STATUS_PENDING" => "pending",
    "STATUS_SENT"    => "sent",

    /* Adds an email to be sent to the queue */
    "add" => function($to, $subject, $message) use($app) {

        $data = [
            "to"      => $to,
            "subject" => $subject,
            "message" => $message,
            "status"  => $this->STATUS_PENDING
        ];

        $app->module("datastore")->save_entry($this->tablename, $data);
    },

    /* Add several emails to the queue.
     *   $bulkdata = [
     *     ["to" => "foo@example.com", "subject" => "Hi", "message" => "Hello World"],
     *     ...
     *    ];
     */
    "addBulk" => function($bulkdata) use($app) {
        foreach ($bulkdata as $entry) {
            $this->add($entry['to'], $entry['subject'], $entry['message']);
        }
    },

    /*
     * Check if the queue is empty, meaning there ae no pending emails.
     */
    "isEmpty" => function() use($app) {
        return $this->count() === 0;
    },

    /*
     * Returns the number of pending emails
     */
    "count" => function() use($app) {
        return count($this->getPending());
    },

    /* Get all pending emails */
    "getPending" => function($limit=null) use($app) {

        $filter = ["status" => $this->STATUS_PENDING];
        $params = ["filter" => $filter];

        if($limit !== null) {
            $params["limit"] = $limit;
        }

        return $app->module("datastore")->find($this->tablename, $params)->toArray();
    },

    /*
     * Processes the given number of pending entries and sends emails out
     */
    "process" => function($step=10) use($app) {

        $entries = $this->getPending($limit = $step);

        foreach ($entries as $entry) {
            // send
            $app->mailer->mail($entry['to'], $entry['subject'], $entry['message']);

            // update entry status
            $entry['status'] = $this->STATUS_SENT;
            $app->module("datastore")->save_entry($this->tablename, $entry);
        }

        return count($entries);
    }
]);

$this->module("datastore")->extend([
    "get_or_create_datastore" => function($name) use($app) {

        $datastore = $this->get_datastore($name);

        if (!$datastore) {

            $datastore = [
                "name"     => $name,
                "modified" => time()
            ];

            $datastore["created"] = $datastore["modified"];

            $app->db->save("common/datastore", $datastore);
        }

        return $datastore;
    }
]);

// ADMIN
if (COCKPIT_ADMIN && !COCKPIT_REST) include_once(__DIR__.'/admin.php');
