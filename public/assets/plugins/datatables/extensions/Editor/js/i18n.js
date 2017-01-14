/**
 * Created by john on 2017-01-13.
 */

define(function(require, exports, module) {
    module.exports = {
        create: {
            button: "新建",
            title: "新建表单",
            submit: "提交"
        },
        edit: {
            button: "保存",
            title: "编辑表单",
            submit: "提交"
        },
        remove: {
            button: "删除",
            title: "删除",
            submit: "提交",
            confirm: {
                _: "确认删除行 %d ?",
                1: "确认删除行 1 行?"
            }
        },
        error: {
            system: "系统错误！"
        },
        datetime: {
            previous: '<',
            next: '>',
            months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            weekdays: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
        }
    }
});