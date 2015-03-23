<?php

namespace Mailqueue\Controller;

class Mailqueue extends \Cockpit\Controller
{
    public function index() {
        $mailqueue = cockpit("mailqueue");

        // pending emails
        $mails    = $mailqueue->getPending();

        // link to underlying datastore table
        $store    = cockpit("datastore")->get_or_create_datastore($mailqueue->tablename);
        $storeurl = $this->app->routeUrl("/datastore/table/".$store['_id']);

        return $this->render("mailqueue:views/index.php",
            compact('mails', 'storeurl'));
    }

    public function process() {

        if (cockpit("mailqueue")->isEmpty()) {
            return '{"count": 0}';
        }

        cockpit("mailqueue")->process($step=5);

        return json_encode(["count" => cockpit("mailqueue")->count() ]);
    }
}