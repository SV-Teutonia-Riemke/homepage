import * as monaco from 'monaco-editor';

(function () {
    const textarea = document.getElementsByClassName('monaco-editor')[0];
    const div      = document.createElement('div');
    div.style      = 'width:100%; height:800px; border: 1px solid #ccc;';

    textarea.parentNode.appendChild(div);
    textarea.style.display = 'none';

    let monacoEditor = monaco.editor.create(div, {
        value: textarea.textContent,
        language: textarea.getAttribute('data-language'),
    });

    monacoEditor.onDidChangeModelContent((e) => {
        textarea.value = monacoEditor.getModel().getValue();
    });
})();
