import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProductVipComponent } from './product-vip.component';

describe('ProductVipComponent', () => {
  let component: ProductVipComponent;
  let fixture: ComponentFixture<ProductVipComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ProductVipComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProductVipComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
