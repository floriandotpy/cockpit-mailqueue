@start('header')

    {{ $app->assets(['mailqueue:assets/mailqueue.js']) }}

@end('header')

<div class="uk-panel uk-panel-box uk-text-center">

    <div class="uk-text-right">
        <a href="{{ $storeurl }}" class="uk-button">Underlying datastore</a>
    </div>

    @if (count($mails))

        <h1>{{count($mails)}} pending mails in the queue</h1>
        <p>Hit the process button once you're ready.</p>
        <a href="" class="uk-button uk-button-success" data-processing-start>Start processing</a>
        <a href="" class="uk-button uk-button-danger uk-hidden" data-processing-stop>Stop processing</a>

        <div class="uk-alert uk-alert-success uk-hidden" data-processing-state>Starting...</div>

        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <td>Email</td>
                    <td>Subject</td>
                    <td>Message</td>
                </tr>
            </thead>
            @foreach($mails as $mail)
            <tr>
                <td>{{{ $mail["to"] }}}</td>
                <td class="uk-text-muted">{{{ $mail["subject"] }}}</td>
                <td class="uk-text-muted">{{{ substr($mail["message"], 0, 80) }}} ...</td>
            </tr>
            @endforeach
        </table>

    </div>

    @else
        <h1>The queue is empty</h1>
        <p>There are currently no pending emails in the queue</p>
    @endif