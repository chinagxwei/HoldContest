import { TestBed } from '@angular/core/testing';

import { OrderIncomeConfigService } from './order-income-config.service';

describe('OrderIncomeConfigService', () => {
  let service: OrderIncomeConfigService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(OrderIncomeConfigService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
