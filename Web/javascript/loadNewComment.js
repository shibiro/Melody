
jQuery(document).ready(function(){
    setInterval('loadNewComment()', 3000);
});

function change(time) {
    var r = time.match(/^\s*([0-9]+)\s*-\s*([0-9]+)\s*-\s*([0-9]+)(.*)$/);
    return r[2]+"-"+r[3]+"-"+r[1]+r[4];
}

function buildComment(comment){

    return $('<fieldset></fieldset>')
        .addClass('comment')
        .attr('data-id',comment.id)
        .append(
        $('<legend></legend>')
            .append(
            'Poste par ',
            $('<a></a>')
                .attr('href','/Membre/index-'+ comment.auteur )
                .html( comment.auteur)
                .css('font-weight','bold'),
            ' le ' + comment.date
        ),
        $('<p></p>')
            .html(comment.contenu)
    );
}


function getComment(where){
    return {
        id : $('.comment:'+where+'').attr('data-id'),
        news_id : $('.news').attr('data-id')
    };
}

function hideButton(){
    $(".old-comment").css("visibility", "hidden");
}

function loadNewComment()    {
    var comment = getComment('first');
    loadCommentsUsingCommentId('/News/getNewComments',comment);
};

function loadOldComment()    {
    var comment = getComment('last');
    loadCommentsUsingCommentId('/News/getOldComments',comment);
};

function loadCommentsUsingCommentId(url,comment) {

    $.post(url, {newsid: comment.news_id, commentid: comment.id}, function (data)
    {
        pushComment(data);
    },'json');
}

function pushComment(data) {
    if (data === null) return false;

    var firstComment = getComment('first');
    var lastComment = getComment('last');


    $.each(data, function (index, comment) {

        if (parseInt(firstComment.id) < parseInt(comment.id) ) {
            buildComment(comment).insertBefore('.comment:first');
            firstComment.id = comment.id;
        }
        else {
            if(index<5){
                buildComment(comment).insertAfter('.comment:last');
                lastComment.id = comment.id;

            }
            indexmax=index;
        }

    });

    if(typeof indexmax != 'undefined' && indexmax !=5){
        hideButton();
    }
}

function hideComment(){
    var i = 0;
    while (i<4 && $('.comment:'+'last'+'').attr('data-id')!=$('.comment:'+'first'+'').attr('data-id')){

        $('.comment:'+'last'+'').remove();
        i++;
    }
}


