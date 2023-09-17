import { Component } from '@angular/core';
import { CartService } from '../cart.service';
import { TemplateLiteral } from '@angular/compiler';
@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.scss']
})
export class CartComponent {
constructor(private cartService: CartService){

}
 cartArr:any=[]
 total!:number
  dataArr:any
 ngOnInit(){


  this.cartService.getCart().subscribe(
    myData=>{
      this.dataArr=  Object.values(myData)
      this.dataArr =Object.values(this.dataArr[0])
      console.log(this.dataArr)
      this.total=0;
     for(let i=0; i<this.dataArr.length; i++){
      console.log(this.dataArr[i].product_subtotal )
     this.total+=Number(this.dataArr[i].product_subtotal)
     }
    }
    )
}
delCartFunction(){
  this.cartService.delCart().subscribe(data =>console.log(data),err=>console.log(err));
}
decreaseCartItem(item:any){
if(item.product_quantity<=1 ){
  window.alert("can't decrease product quantity less than 1 if you want delete it click on delete cart item")
}else{

  this.cartService.decreaseCartItem(item.id).subscribe(data =>{console.log(data)
   this.ngOnInit()
 },err=>console.log(err));
}
}
increaseCartItem(item:any){
  // const indexOfObject = this.dataArr.find((object:any) => {
  //   return object.product_name == item.name;
  // });
  // console.log(indexOfObject.id); //  1
     this.cartService.increaseCartItem(item).subscribe(data =>{console.log(data)
      this.ngOnInit()
    },err=>console.log(err));
  }
  deleteCartItem(item:any){
   this.cartService.delCartItem(item).subscribe(data =>{console.log(data)
     this.ngOnInit()});
  }

}
