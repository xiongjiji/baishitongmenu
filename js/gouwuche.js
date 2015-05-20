utils = {
    setParam : function (name,value){
        localStorage.setItem(name,value)
    },
    getParam : function(name){
        return localStorage.getItem(name)
    }
}

product={
    name:"",
    amount:0,
    price:0.00,
    amountName:""
};
orderdetail={
    username:"",
    phone:"",
    address:"",
    zipcode:"",
    totalNumber:0,
    totalAmount:0.00    
}
cart = {
    //向购物车中添加商品
    addproduct:function(product){
        var ShoppingCart = utils.getParam("ShoppingCart");
        if(ShoppingCart==null||ShoppingCart==""){
			//第一次加入商品
            var jsonstr = {"productlist":[{"name":product.name,"amount":product.amount,"price":product.price,"amountName":product.amountName}]};
            utils.setParam("ShoppingCart","'"+JSON.stringify(jsonstr));
        }else{
            var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
            var productlist = jsonstr.productlist;
            var result=false;
			//查找购物车中是否有该商品
            for(var i in productlist){
                if(productlist[i].name==product.name){
                    productlist[i].amount=parseInt(product.amount);
                    result = true;
                }
            }
            if(!result){
				//没有该商品就直接加进去
                productlist.push({"name":product.name,"amount":product.amount,"price":product.price,"amountName":product.amountName});
            }
			//重新计算总价
            jsonstr.totalNumber=parseInt(productlist[i].amount);
            jsonstr.totalAmount=parseInt(product.amount)*parseFloat(product.price);
            orderdetail.totalNumber = jsonstr.totalNumber;
            orderdetail.totalAmount = jsonstr.totalAmount;
            //保存购物车
            utils.setParam("ShoppingCart","'"+JSON.stringify(jsonstr));
        }
    },
    // 计算总价
     totalNumber:function(){
        var ShoppingCart = utils.getParam("ShoppingCart");
        var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
        var productlist = jsonstr.productlist;
        var totalsum = [];//建立totalsum数组

        for(var i in productlist){
            // 计算单个产品价格。加入totalsum数组
            sum = parseInt(productlist[i].amount)*parseFloat(productlist[i].price);
            totalsum.push(sum);

            // 定义总价变量
            var  totalprice = 0;
            for(i=0;i<totalsum.length;i++){
                
                totalprice += totalsum[i];
            }
            // var totalNumber += amount*price;
        }
        return totalprice;
    },
    //修改给买商品数量
    updateproductnum:function(id,num){
        var ShoppingCart = utils.getParam("ShoppingCart");
        var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
        var productlist = jsonstr.productlist;
        
        for(var i in productlist){
            if(productlist[i].id==id){
                jsonstr.totalNumber=parseInt(jsonstr.totalNumber)+(parseInt(num)-parseInt(productlist[i].num));
                jsonstr.totalAmount=parseFloat(jsonstr.totalAmount)+((parseInt(num)*parseFloat(productlist[i].price))-parseInt(productlist[i].num)*parseFloat(productlist[i].price));
                productlist[i].num=parseInt(num);
                
                orderdetail.totalNumber = jsonstr.totalNumber;
                orderdetail.totalAmount = jsonstr.totalAmount;
                utils.setParam("ShoppingCart","'"+JSON.stringify(jsonstr));
                return;
            }
        }
    },
    //获取购物车中的所有商品
    getproductlist:function(){
        var ShoppingCart = utils.getParam("ShoppingCart");
        var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
        var productlist = jsonstr.productlist;
        orderdetail.totalNumber = jsonstr.totalNumber;
        orderdetail.totalAmount = jsonstr.totalAmount;
        return productlist;
    },
    //判断购物车中是否存在商品
    existproduct:function(id){
        var ShoppingCart = utils.getParam("ShoppingCart");
        var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
        var productlist = jsonstr.productlist;
        var result=false;
        for(var i in productlist){
            if(productlist[i].id==product.id){
                result = true;
            }
        }
        return result;
    },
    //删除购物车中商品
    deleteproduct:function(id){
        var ShoppingCart = utils.getParam("ShoppingCart");
        var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
        var productlist = jsonstr.productlist;
        var list=[];
        for(var i in productlist){
            if(productlist[i].id==id){
                jsonstr.totalNumber=parseInt(jsonstr.totalNumber)-parseInt(productlist[i].num);
                jsonstr.totalAmount=parseFloat(jsonstr.totalAmount)-parseInt(productlist[i].num)*parseFloat(productlist[i].price);
            }else{
                list.push(productlist[i]);
            }
        }
        jsonstr.productlist = list;
        orderdetail.totalNumber = jsonstr.totalNumber;
        orderdetail.totalAmount = jsonstr.totalAmount;
        utils.setParam("ShoppingCart","'"+JSON.stringify(jsonstr));
    }
};