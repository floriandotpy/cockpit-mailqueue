<?php

// ACL
$this("acl")->addResource('Mailqueue', ['manage.mailqueue']);

$app->on('admin.init', function() {

    $datastore = $this->module("datastore");
    $mailqueue = $this->module("mailqueue");

    // make sure datastore exists
    if($store = $datastore->get_or_create_datastore($mailqueue->tablename)) {

        $this('admin')->menu('top', [
            'url'    => $this->routeUrl("/mailqueue"),
            'label'  => '<i class="uk-icon-envelope"></i>',
            'title'  => $this('i18n')->get('Mailqueue'),
            'active' => (strpos($this['route'], "/mailqueue") === 0)
        ], 5);
    }

    $this->bindClass('Mailqueue\\Controller\\Mailqueue', 'mailqueue');

});