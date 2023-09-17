import { Component } from '@angular/core';
import { CartService } from '../cart.service';
import { FormControl,FormGroup,Validators } from '@angular/forms';
import { OrderService } from '../order.service';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.scss']
})
export class CheckoutComponent {
  total!:number
  count!:number
  dataArr:any
  constructor(private cartService:CartService, private orderService:OrderService){}
  ngOnInit() {
  this.cartService.getCart().subscribe(
    myData=>{
      this.dataArr=  Object.values(myData)
      this.dataArr =Object.values(this.dataArr[0])
      console.log(this.dataArr)
      this.total=0;
      this.count=0;
     for(let i=0; i<this.dataArr.length; i++){

     this.total+=Number(this.dataArr[i].product_subtotal)
     this.count+=Number(this.dataArr[i].product_quantity)
     }
     console.log(this.total)
    }
    )
  }
  OrderForm:FormGroup = new FormGroup({

    'customer_name':new FormControl(null,[Validators.minLength(3),Validators.required]),
    'customer_email':new FormControl(null,[Validators.email,Validators.required]),
    'customer_phone':new FormControl(null,[Validators.minLength(5),Validators.maxLength(20),Validators.required]),
    'customer_address':new FormControl(null,[Validators.minLength(10),Validators.maxLength(40),Validators.required]),
   })
   submitOrder(Order:any){
    console.log(Order.value)
     this.orderService.checkout(Order.value).subscribe(data =>console.log(data))
   }
}
