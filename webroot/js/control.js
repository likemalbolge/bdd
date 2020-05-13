$('document').ready(function () {
    if (window.location.pathname == '/bdd/games/gamepage')
    {
        $('.comment-text').val(taVal);

        var comments = $('.cmnt_body');
        var comments_id = $('.cmnt-id').toArray();

        if (userType == 'admin')
        {
            for (var i = 0; i < comments.length; i++)
            {
                $(comments[i]).find('.control').css('display', 'inline');
                onControlClick(comments, comments_id, i);
            }
        } else
        {
            for (var k = 0; k < comments_id.length; k++)
            {
                for (var j = 0; j < uc.length; j++)
                {
                    if (uc[j]['id'] == comments_id[k].textContent)
                    {
                        $(comments[k]).find('.control').css('display', 'inline');
                        onControlClick(comments, comments_id, k);
                    }
                }
            }
        }
    }
});

function onControlClick(comments, comments_id, i) {
    $(comments[i]).find('.control-edit').click(function () {
        window.location.href = link + '&do=edit&cid=' + comments_id[i].textContent;
    });
    $(comments[i]).find('.control-delete').click(function () {
        window.location.href = link + '&do=delete&cid=' + comments_id[i].textContent;
    });
}