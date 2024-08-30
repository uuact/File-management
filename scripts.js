function updateLinks() {
    // 获取选择框的当前值
    var action = document.getElementById('fileAction').value;
    
    // 查找所有文件项
    var fileItems = document.querySelectorAll('.imgcss a, .txtcss a');
    
    fileItems.forEach(function(fileLink) {
        if (action === 'view') {
            // 如果选择框是查看，则移除下载属性
            fileLink.removeAttribute('download');
        } else if (action === 'download') {
            // 如果选择框是下载，则添加下载属性
            fileLink.setAttribute('download', fileLink.getAttribute('href').split('/').pop());
        }
    });
}
