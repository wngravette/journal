@extends('journal.master')
@section('content')
<script>
$(document).ready(function() {
    $('textarea.pad').elastic();

    function moveCaretToEnd(el) {
        if (typeof el.selectionStart == "number") {
            el.selectionStart = el.selectionEnd = el.value.length;
        } else if (typeof el.createTextRange != "undefined") {
            el.focus();
            var range = el.createTextRange();
            range.collapse(false);
            range.select();
        }
    }

    var textarea = document.getElementById("pad");
    textarea.onfocus = function() {
        moveCaretToEnd(textarea);
        // Work around Chrome's little problem
        window.setTimeout(function() {
            moveCaretToEnd(textarea);
        }, 1);
    };

    function wordCount( val ){
        return {
            charactersNoSpaces : val.replace(/\s+/g, '').length,
            characters         : val.length,
            words              : val.match(/\S+/g).length,
            lines              : val.split(/\r*\n/).length
        }
    }

    var $words = $('span.words');
    var $words_init_span = $('span.init_words');

    $('textarea#pad').on('input', function(){
        var c = wordCount( this.value );
        $words.html(c.words);
        $words_init_span.html(c.words);
    });

    // WORKS SOMETIMES, BUT WILL SOMETIMES CAUSE TROUBLE. BUG?

    // var open_words = wordCount( $('textarea#pad').val() );
    // $words.html(open_words.words);
    // $words_init_span.html(open_words.words);

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
        };
    })();

    $('textarea#pad').keyup(function() {

        $("html, body").animate({ scrollTop: $(document).height() }, 100);
        delay(function(){
            var entry_body = $('textarea#pad').val();
            var $save_block = $('span.save');
            var c = $("span.words").html();
            $.ajax({
                method: "POST",
                url: "journal/entries/{{$todays_entry->id}}",
                data: {
                    entry_body: entry_body,
                    word_count: c
                },
                beforeSend: function() {
                    $save_block.html('Saving...');
                },
                success: function() {
                    $save_block.html('<span>Saved.</span>');
                }
            });
        }, 1000 );
    });

});
</script>
<div class="columns intro">
    <div class="single-column column">
        <h2>It's {{$date}}, and
            @if(!$todays_entry)
            you do not have an entry for today.
            @else
            you've written <span class="init_words">no</span> words for today.
            @endif
        </h2>
        <h2>You've got <span class="timeago" title="{{$midnight}}"></span> until writing closes for today.</h2>
    </div>
</div>
<div class="columns pad">
    <div class="single-column column">
        <textarea id="pad" name="entry_body" class="pad input-block" cols="90" autofocus placeholder="Begin your journal for today...">@if($todays_entry){{$todays_entry->entry_body}}@endif</textarea>
    </div>
</div>
<div class="columns info">
    <div class="single-column column entry_info">
        <p class="stats"><span class="info_block"><span class="words">0</span><span class="slash">/</span><span class="tooltipped tooltipped-n" aria-label="Your recommended word count goal.">500</span> words</span><span class="info_block"><span class="save"></span></span></p>
    </div>
</div>
@endsection
