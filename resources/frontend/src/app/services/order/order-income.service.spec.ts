import { TestBed } from '@angular/core/testing';

import { OrderIncomeService } from './order-income.service';

describe('OrderIncomeService', () => {
  let service: OrderIncomeService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(OrderIncomeService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
