import { Config } from 'config.js';

class Token {

  constructor() {
    this.verifyUrl = Config.restUrl + 'token/verify';
    this.tokenUrl = Config.restUrl + 'token/user';
  }

  verify() {
    var token = wx.getStorageSync('token');
    if(!token){
      this.getTokenFromServer();
    }else{
      this._veirfyFromServer(token);
    }
  }

  //获取服务器TOKEN
  getTokenFromServer(callBack){
    var that = this;
    wx.login({
      success: function(res){
        wx.request({
          url: that.tokenUrl,
          method: 'POST',
          data:{
            code: res.code
          },
          success: function(res){
            wx.setStorageSync('token', res.data.token);
            callBack && callBack(res.data.token);
          }
        })
      }
    })  
  }

  //携带令牌校验令牌
  _veirfyFromServer(token){
    var that = this;
    wx.request({
      url: that.verifyUrl,
      method: 'POST',
      data: {
        token: token
      },
      success: function (res) {
        var valid = res.data.isValiid;
        if (!valid){
          that.getTokenFromServer();
        }
      }
    })
  }



}

export { Token };