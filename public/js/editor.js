// https://nhn.github.io/tui.editor/latest/
// https://github.com/nhn/tui.editor/blob/master/docs/en/getting-started.md
$(document).ready(function () {
    if (0 < $("#editor-question").length) {
        const editorQuestion = new toastui.Editor({
            el: document.querySelector('#editor-question'),
            height: '200px',
            initialEditType: 'markdown',
            previewStyle: 'vertical',
            initialValue: $("#question_question").val(),
            usageStatistics: false,
            hideModeSwitch: true,
            toolbarItems: [
                ['heading', 'bold', 'italic', 'strike'],
                ['hr', 'quote'],
                ['ul', 'ol', 'indent', 'outdent'],
                ['table', 'image', 'link'],
                ['code'],
                ['scrollSync'],
            ],
        });

        const editorAnswer = new toastui.Editor({
            el: document.querySelector('#editor-answer'),
            height: '200px',
            initialEditType: 'markdown',
            previewStyle: 'vertical',
            initialValue: $("#question_answer").val(),
            usageStatistics: false,
            hideModeSwitch: true,
            toolbarItems: [
                ['heading', 'bold', 'italic', 'strike'],
                ['hr', 'quote'],
                ['ul', 'ol', 'indent', 'outdent'],
                ['table', 'image', 'link'],
                ['code'],
                ['scrollSync'],
            ],
        });

        $("#question_form").submit(function () {
            $("#question_question").val(editorQuestion.getMarkdown())
            $("#question_answer").val(editorAnswer.getMarkdown())
        })
    }

    // Disable/Remove image upload
    // https://github.com/nhn/tui.editor/issues/1204#issuecomment-1068364431
    window.onload = () => {
        const observer = new MutationObserver(() => {
            if (document.querySelector('.toastui-editor-popup.toastui-editor-popup-add-image')) {
                document.querySelector('[aria-label="URL"]').click();
                document.querySelector('[aria-label="File"]').style.display = "none";
            }
        });
        const target = document.querySelector(".toastui-editor-popup ");
        observer.observe(target, { attributes: true, attributeFilter: ["style"] });
    }
});