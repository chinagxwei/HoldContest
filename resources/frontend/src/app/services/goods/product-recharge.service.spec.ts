import { TestBed } from '@angular/core/testing';

import { ProductRechargeService } from './product-recharge.service';

describe('ProductRechargeService', () => {
  let service: ProductRechargeService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ProductRechargeService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
