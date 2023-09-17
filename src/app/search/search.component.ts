import { Component, OnInit } from '@angular/core';
import { ProductsService } from '../products.service';
import { ActivatedRoute, Router } from '@angular/router'
import { CartService } from '../cart.service';
import { DataSharingService } from '../data-sharing.service';
@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.scss']
})
export class SearchComponent implements OnInit{
  searchValue:string =''
  values:any
  search: any=''
  cartLength:number=0;
  selected!:boolean
  dataArr:any
  constructor(private route: ActivatedRoute,private router:Router,
    private productsService: ProductsService,private cartService: CartService,private dataSharingService: DataSharingService) {
      this.dataSharingService.CartLength.subscribe( value => {
        this.cartService.cartLength = value;

    });
  }
  ngOnInit() {
     this.dataArr
    this.cartService.getCart().subscribe(myData=>{
      this.dataArr=  Object.values(myData)
      this.dataArr =Object.values(this.dataArr[0])
    this.cartService.cartLength =this.dataArr.length

    },
    (err)=>{console.log(err)}
    )

    this.route.params.subscribe(routeParams => {
      routeParams=  Object.values(routeParams);
      this.search= routeParams.toString()
      if(this.values==null){
        if(this.search!=='') {
          this.productsService.getProducts().subscribe(

            (value) => {this.values = value
            this.values=  this.values.filter((product:any)=>product.name.toLowerCase().includes(this.search.toLowerCase()))
              console.log(this.values)
         },(err)=>{console.log(err)});

        }
      }else{
        this.values=this.dataArr
      }
      }


    );

}

addToCartFunction(item:any) {
  let x=this.dataArr.findIndex((element:any)=>element.product_id==item.product_id)
      console.log( x)
      if(x!=-1) {
        window.alert("item is already added")

      }else{
        this.cartService.addToCart(item).subscribe(
          (value) => {
            this.cartService.getCart().subscribe(myData=>{
              this.dataArr=  Object.values(myData)
              this.dataArr =Object.values(this.dataArr[0])
              this.dataSharingService.CartLength.next(this.dataArr.length)
            },
            (err)=>{console.log(err)}
            )
        },(err)=>{console.log(err)});
      }


}



}

