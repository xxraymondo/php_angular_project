import { Component } from '@angular/core';
import { FormControl,FormGroup,Validators } from '@angular/forms';
import { ProductsService } from '../products.service';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.scss']
})
export class ProductsComponent {
constructor(public productsService: ProductsService){

}
  ProductForm:FormGroup = new FormGroup({
    'name':new FormControl(null),
    'description':new FormControl(null),
    'price':new FormControl(null),
    'stock':new FormControl(null),
    'image':new FormControl(null),
    'category':new FormControl(null),
    'status':new FormControl(null),
    // 'name':new FormControl(null,[Validators.minLength(3),Validators.maxLength(40),Validators.required]),
    // 'description':new FormControl(null,[Validators.minLength(3),Validators.maxLength(40),Validators.required]),
    // 'price':new FormControl(null,[Validators.min(1),Validators.required]),
    // 'stock':new FormControl(null,[Validators.min(1),Validators.required]),
    // 'image':new FormControl(null,Validators.required),
    // 'category':new FormControl(null,[Validators.minLength(3),Validators.maxLength(20),Validators.required]),
    // 'status':new FormControl(null,[Validators.minLength(2),Validators.maxLength(15),Validators.required]),
   })
   submitProduct(product:any){
    console.log(product.value)
    this.productsService.createProduct(product.value).subscribe(data =>console.log(data),err=>console.log(err))
   }
}
