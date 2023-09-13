import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OrderIncomeComponent } from './order-income.component';

describe('OrderIncomeComponent', () => {
  let component: OrderIncomeComponent;
  let fixture: ComponentFixture<OrderIncomeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ OrderIncomeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(OrderIncomeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
