// pages/cart/cart.js

import { Cart } from 'cart-model.js';
var cart = new Cart();

Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
  },

  onHide:function(){
    cart.execSetStorageSync(this.data.cartData);
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var cartDate = cart.getCatDataFromLocal();
    // var countsInfo = cart.getCartTotalCounts(true);
    var cal = this._calcTotalAccountAndCounts(cartDate);

    this.setData({
      selectedCounts: cal.selectedCounts,
      selectedTypeCounts: cal.selectedTypeCounts,
      account: cal.account,
      cartData: cartDate
    });
  },

  _calcTotalAccountAndCounts:function(data){
    var len = data.length,
        //所需计算的总价格，但需要注意排除未选择的商品
        account = 0,
        //购买商品的总数量
        selectedCounts = 0,
        //购买数量种类的总数
        selectedTypeCounts = 0;

    let multiple = 100;

    for(let i = 0; i < len; i++){
      if(data[i].selectStatus){
        account += data[i].counts * multiple * Number(data[i].price) * multiple;
        selectedCounts += data[i].counts;
        selectedTypeCounts++;
      }
    }

    return {
      selectedCounts: selectedCounts,
      selectedTypeCounts: selectedTypeCounts,
      account: account / (multiple * multiple)
    }

  },

  toggleSelect: function(event){
    var id = cart.getDataSet(event, "id"),
      status = cart.getDataSet(event, 'status'),
      index = this._getProductIndexById(id);
    
    this.data.cartData[index].selectStatus = !status;
    this._resetCartData();
  },

  _resetCartData: function(){
    // 重新计算金额和数量
    var newData = this._calcTotalAccountAndCounts(this.data.cartData);
    this.setData({
      selectedCounts: newData.selectedCounts,
      selectedTypeCounts: newData.selectedTypeCounts,
      account: newData.account,
      cartData: this.data.cartData
    });
  },

  toggleSelectAll:function(event){
    var status = cart.getDataSet(event, 'status') == 'true';

    var data = this.data.cartData,
      len = data.length;
    for (let i = 0; i < len; i++) {
      data[i].selectStatus = !status;
    }
    this._resetCartData();
  },

  //更具商品ID得到 商品所在的下标
  _getProductIndexById: function(id){
    var data = this.data.cartData,
    len = data.length;
    for(let i = 0; i < len; i++ ){
      if(data[i].id == id){
        return i;
      }
    }
  },

  changeCounts:function(event){
    var id = cart.getDataSet(event, 'id'),
      type = cart.getDataSet(event, 'type'),
      index = this._getProductIndexById(id),
      counts = 1;
    
    if(type == 'add'){
      cart.addCounts(id);
    }else{
      counts = -1;
      cart.cutCounts(id);
    }

    this.data.cartData[index].counts += counts;
    this._resetCartData();
  },

  delete: function(event){
    var id = cart.getDataSet(event, 'id'),
      index = this._getProductIndexById(id);
    this.data.cartData.splice(index,1);
    this._resetCartData();
    cart.delete(id);
  },

  submitOrder:function(event){
    wx.navigateTo({
      url: '../order/order?account='+this.data.account +'&form=cart',
    })
  }


})