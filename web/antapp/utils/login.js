if (typeof wx === 'undefined') var wx = getApp().hj;
/**

 * Date: 2018/5/11
 * Time: 18:37
 */
module.exports = function (args) {
    var pages = getCurrentPages();
    if (pages.length) {
        var current_page = pages[pages.length - 1];
        if (current_page && current_page.route != 'pages/login/login') {
            if (typeof my !== 'undefined') {
                // alipay
                var last_page_options = wx.getStorageSync('last_page_options');
                var _page = {
                    route: pages[(pages.length - 1)].route,
                    options: last_page_options ? last_page_options : {},
                };
                wx.setStorageSync('login_pre_page', _page);
            } else {
                // wechat
                wx.setStorageSync('login_pre_page', current_page);
            }
        }
    }
    wx.redirectTo({
        url: '/pages/login/login',
    });
};