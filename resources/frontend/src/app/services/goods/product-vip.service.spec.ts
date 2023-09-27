import { TestBed } from '@angular/core/testing';

import { ProductVipService } from './product-vip.service';

describe('ProductVipService', () => {
  let service: ProductVipService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ProductVipService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
