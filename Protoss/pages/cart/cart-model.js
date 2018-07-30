
import { Base } from '../../utils/base.js';

class Cart extends Base {

  constructor() {
    super();
    this._storagekeyName = 'cart';
  }


  add(item, counts){
    var carData = this.getCatDataFromLocal();

    var isHasInfo = this._isHasThatOne(item.id,carData);
    if(isHasInfo.index === -1){
      item.counts = counts;
      item.selectStatus = true; //是否选择状态
      carData.push(item);
    }else{
      carData[isHasInfo.index].counts += counts;
    }
    wx.setStorageSync(this._storagekeyName, carData);
  }

  // 从缓存中读取购物车数量
  getCatDataFromLocal(flag){
    var res = wx.getStorageSync(this._storagekeyName);
    if(!res){
      res = [];
    }

    //在下单时候过滤不下单的商品
    if (flag){
      var newRes = [];
      for (let i = 0; i < res.length; i++) {
        if(res[i].selectStatus){
          newRes.push(res[i]);
        }
      }
      res = newRes;
    }

    return res;
  }

  _isHasThatOne(id, arr){
    var item,
    result = {index:-1};
    for(let i = 0; i<arr.length;i++){
      item = arr[i];
      if(item.id == id){
        result = {
          index: i,
          Date: item
        };
        break;
      }
    }
    return result;
  }

  //获取购物总数量
  // flag true 考虑选中状态
  getCartTotalCounts(flag){
    var data = this.getCatDataFromLocal();
    var counts = 0;
    for(let i=0; i<data.length ;i++){
      if(flag){
        if(data[i].selectStatus){
          counts += data[i].counts;
        }
      }else{
        counts += data[i].counts;
      }
    }
    return counts;
  }

  /**
   * 修改商品数目
   * params:
   * id -- 商品ID
   * counts -- 数目
   */
  _changeCounts(id, counts){
    var carData = this.getCatDataFromLocal(),
      hasInfo = this._isHasThatOne(id, carData);
    if (hasInfo.index != -1){
      if (hasInfo.Date.counts > 1){
        carData[hasInfo.index].counts += counts;
      }
    }
    wx.setStorageSync(this._storagekeyName, carData);
  }

  /***
   * 增加数目
   */
  addCounts(id){
    this._changeCounts(id,1);
  }

  /***
   * 减数目
   */
  cutCounts(id) {
    this._changeCounts(id, -1);
  }

  delete(ids){
    if(!(ids instanceof Array)){
      ids = [ids];
    }
    var carData = this.getCatDataFromLocal();
    for (let i = 0; i < ids.length; i++) {
      var hasInfo = this._isHasThatOne(ids[i],carData);
      if( hasInfo.index != -1){
        carData.splice(hasInfo.index,1);
      }
    }
    wx.setStorageSync(this._storagekeyName, carData);
  }

  execSetStorageSync(data){
    wx.setStorageSync(this._storagekeyName, data);
  }

}

export { Cart };