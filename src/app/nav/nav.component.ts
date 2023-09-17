import { Component, OnInit } from '@angular/core';
import { ProductsService } from '../products.service';
import { CartService } from '../cart.service';
import { DataSharingService } from '../data-sharing.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})


export class NavComponent implements OnInit {

  values = '';
  message:string =''
   loggedIn:Boolean=false;
    dataArr:any
    dataArrayLength!:number;
admin:boolean=false
name!:any
  constructor(private productsService: ProductsService,private cartService:CartService ,private dataSharingService: DataSharingService){
    this.dataSharingService.CartLength.subscribe( value => {
      this.cartService.cartLength = value;

  });

  }

  ngOnInit(): void {
    this.dataSharingService.notifyObservable$.subscribe(res => {
        this.dataArrayLength = res
})

 if(localStorage.getItem('token') == null){
  this.loggedIn = false;

 }else{
  this.loggedIn = true;
  this.name=localStorage.getItem('name')
 }
 if(localStorage.getItem('role')==null||localStorage.getItem('role')=='user'){
  this.admin=false
 }else{
  this.admin=true
 }


  this.cartService.getCart().subscribe(myData=>{
    this.dataArr=  Object.values(myData)
  this.dataArr =Object.values(this.dataArr[0])
  this.dataArrayLength=this.dataArr.length
  this.cartService.cartLength=this.dataArrayLength

  },
  (err)=>{console.log(err)}
  )
  }
  logout(){
    localStorage.removeItem('token');
    localStorage.removeItem('role');
    localStorage.removeItem('name');
    this.ngOnInit()
  }
  onKey(event: any) { // without type info
    this.values= event.target.value
    if(this.values!=='') {
    this.productsService.getProducts().subscribe((products)=>{

      let x= products.filter((product:any)=>product.name.toLowerCase().includes(this.values.toLowerCase()))

   },(err)=>{console.log(err)});
  }}

}
