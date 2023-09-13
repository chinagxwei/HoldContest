import {Goods, ProductRecharge, ProductVip} from './goods';

describe('Goods', () => {
  it('should create an instance', () => {
    expect(new Goods()).toBeTruthy();
  });
});

describe('ProductRecharge', () => {
  it('should create an instance', () => {
    expect(new ProductRecharge()).toBeTruthy();
  });
});

describe('ProductVip', () => {
  it('should create an instance', () => {
    expect(new ProductVip()).toBeTruthy();
  });
});
