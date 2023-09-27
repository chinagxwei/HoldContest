import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OrderIncomeConfigComponent } from './order-income-config.component';

describe('OrderIncomeConfigComponent', () => {
  let component: OrderIncomeConfigComponent;
  let fixture: ComponentFixture<OrderIncomeConfigComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ OrderIncomeConfigComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(OrderIncomeConfigComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
