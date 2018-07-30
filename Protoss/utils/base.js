
import { Config } from '../utils/config.js';
import { Token } from '../utils/token.js';

class Base{
  constructor(){
    this.baseRequesUrl = Config.restUrl
  }

  request(params, noRefetch = false){
    var url = this.baseRequesUrl + params.url;
    var that = this;
    if(!params.type){
      params.type = 'GET';
    }
    wx.request({
      url: url,
      data: params.data,
      method: params.type,
      header: {
        'content-type':'application/json',
        'token':wx.getStorageSync('token')
      },
      success:function(res){
        var code = res.statusCode.toString();
        var startChar = code.charAt(0);
        if (startChar == '2'){
          // if(params.sCallBack){
          //   params.sCallBack(res);
          // }
          params.sCallback && params.sCallback(res.data);
        }else {
          if(code == '401'){
            if (!noRefetch){
              that._refetch(params);
              return;
            }
          }
          
          params.eCallback && params.eCallback(res.data);
          
        }
      },
      fail:function(err){
        console.log(err);
      }
    })
  }

  _refetch(params){
    var token = new Token();
    token.getTokenFromServer((token)=>{
      this.request(params,true);
    });
  }

  // 获取元素上绑定的值
  getDataSet(event, key){
    return event.currentTarget.dataset[key];
  }

}

export {Base};