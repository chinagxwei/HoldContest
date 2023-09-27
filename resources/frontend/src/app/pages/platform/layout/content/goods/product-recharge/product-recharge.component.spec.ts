import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProductRechargeComponent } from './product-recharge.component';

describe('ProductRechargeComponent', () => {
  let component: ProductRechargeComponent;
  let fixture: ComponentFixture<ProductRechargeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProductRechargeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProductRechargeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
